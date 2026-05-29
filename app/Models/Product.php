<?php

namespace App\Models;

use App\Models\Producer;
use App\Models\CartItem;
use Database\Factories\ProductFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model {
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'quantity',
        'category',
        'subcategory',
        'producer_id'
    ];

    public function producer() {
        return $this->belongsTo(Producer::class);
    }

    public function cartItems(): HasMany {
        return $this->hasMany(CartItem::class);
    }
}
