<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model {
    use HasFactory;

    protected $fillable = [
        'discount_percent',
        'code_name',
        'availibility',
        'max_use'
    ];

    public function orders() {
        return $this->belongsToMany(Order::class, 'reduces');
    }
}