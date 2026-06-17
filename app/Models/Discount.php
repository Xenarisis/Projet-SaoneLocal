<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Attributes\BelongsToMany;

class Discount extends Model {
    use HasFactory;

    protected $fillable = [
        'discount_percent',
        'code_name',
        'availibility',
        'max_use'
    ];

    public function orders(): BelongsToMany {
        return $this->belongsToMany(Order::class, 'reduces');
    }
}