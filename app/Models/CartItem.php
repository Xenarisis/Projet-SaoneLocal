<?php

namespace App\Models;

use Database\Factories\CartItemFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CartItem extends Model {
    use HasFactory;

    protected $fillable = [
        'product_id',
        'quantity',
    ];

    // protected $hidden = [
        // 'user_id',
        // 'product_id'
    // ];

    public function product(): BelongsTo {
        return $this->belongsTo(Product::class);
    }

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }
}
