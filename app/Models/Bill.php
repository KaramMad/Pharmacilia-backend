<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Bill extends Model
{
    use HasFactory;
    protected $guarded = ['*'];
    protected $casts = ['total'=>'float'];

    protected $hidden = ['pivot'];


    public function order():BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
