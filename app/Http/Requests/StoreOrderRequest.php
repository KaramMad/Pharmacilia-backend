<?php

namespace App\Http\Requests;

use App\Models\product;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;
use App\Providers\GlobalVariablesServiceProvider as GlobalVariables;
use Illuminate\Validation\Rule;

class StoreOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [

            'products' => 'required|array',
            'products.*.product_id' => 'required|integer|min:1|exists:products,id|bail',
            'products.*.quantity' => ['required', 'integer', 'min:1', 'max:1000', 'bail'],
            'products.*' => function ($attribute, $value, $fail) {
                $id = $value['product_id'];
                $product = product::find($id);
                if ($product === null) {
                    $fail("product not found");
                    return false;
                }
                if ($product->stock < (int)$value['quantity']) {
                    $fail("the specified quantity for product with id {$id} is less than the available stock");
                    return false;
                }
            }
        ];
    }
    protected function failedValidation(Validator $validator)
    {
        throw new ValidationException($validator, $this->response($validator));
    }

    //response when validation fails
    protected function response($validator)
    {
        return response()->json([
            'status' => false,
            'message' => 'validation failed',
            'errors' => $validator->errors()
        ], 422);
    }
}
