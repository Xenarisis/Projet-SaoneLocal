<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Follow extends Model {
    use HasFactory;

    protected $fillable = [
        'user_id',
        'producer_id'
    ];
}
