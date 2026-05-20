<?php

namespace App\Models;

use Database\Factories\Cart_itemFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart_item extends Model
{
    use HasFactory;

    protected $fillable = [
        'quantity',
        'created_at',
        'updated_at'
    ];

    protected $hidden = [
        'user_id',
        'product_id'
    ];
}
