<?php

namespace App\Models;

use Database\Factories\ProducerFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producer extends Model {
    use HasFactory;

    protected $fillable = [
        'name',
        'presentation',
        'street_line_1',
        'street_line_2',
        'city',
        'postal_code',
        'user_id'
    ];
}
