<?php

namespace App\Models;

use Database\Factories\ComposeFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compose extends Model
{
    use HasFactory;

    protected $fillable = [
        'quantity',
        'unit_price',
        'created_at',
        'updated_at'
    ];

    protected $hidden = [
        'user_id',
        'product_id'
    ];
}
