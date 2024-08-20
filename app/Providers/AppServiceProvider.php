<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use \Illuminate\Http\JsonResponse;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
    /**
     * @param bool $status
     * @param string $message
     * @param string $dataKey
     * @param mixed $data
     * @param int $error
     * @return jsonResponse
     *
     * returns a typical api response
     */
    public static function apiResponse(string $message = "success", $data = null, string $dataKey = 'data', bool $status = true
    , int $error = 200): JsonResponse
    {
        return response()->json([
            'status' => $status,
            'message' => $message,
            $dataKey => $data
        ], $error);
    }
}
