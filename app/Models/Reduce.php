<?php

namespace App\Models;

use Database\Factories\ReduceFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reduce extends Model {
    use HasFactory;

    protected $fillable = [
        'order_id',
        'discount_id'
    ];
}
