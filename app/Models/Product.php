<?php

namespace App\Models;

use App\Models\Producer;
use App\Models\CartItem;
use App\Models\Bookmark;
use Database\Factories\ProductFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
    
    protected function casts(): array {
        return [
            'price' => 'decimal:2'
        ];
    }

    public function producer() {
        return $this->belongsTo(Producer::class);
    }

    public function cartItems(): HasMany {
        return $this->hasMany(CartItem::class);
    }

    public function reviews(): HasMany {
        return $this->hasMany(Review::class);
    }

    public function bookmarks(): HasMany {
        return $this->hasMany(Bookmark::class);
    }
}
