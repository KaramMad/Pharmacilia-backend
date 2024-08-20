<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class product extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded = ['id'];
    protected $hidden = ['pivot'];

    public function orders():BelongsToMany
    {
        return $this->belongsToMany(Order::class)->withPivot('quantity');
    }
    public function category():BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function favoritedBy():BelongsToMany
    {
        return $this->belongsToMany(User::class, 'product_user')->withTimestamps();
    }

    public function isfav() : bool{
        return auth()->user()->favorites->contains($this->id);
    }
    public function scopeFilter($query, array $filters)
    {
        $query->when(auth()->user()->role == 'user', function ($query) {
            $query->where('expiration_date', '>', now());
        });
        $query->when($filters['search_text'] ?? false, function ($query, $search) {

            $query
                ->where('brand_name', 'like', $search . "%")
                ->orwhere('brand_name_ar', 'like', $search . "%")
                ->orwhere('manufacturer', 'like', $search . "%")
                ->orwhere('manufacturer_ar', 'like', $search . "%");
        });
        $query->when($filters['category'] ?? false, function ($query, $category) {

            $query->whereHas('category', function ($categoryQuery) use ($category) {
                $categoryQuery->withTrashed()->where('category_name', '=', $category)
                ->orwhere('category_name', '=', $category);
            });
        });
        $query->with('category');
    }
}
