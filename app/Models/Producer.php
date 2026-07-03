<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Database\Factories\ProducerFactory;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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

    public function user(): BelongsTo {
        return $this->BelongsTo(User::class);
    }

    public function followers(): HasMany {
        return $this->hasMany(Follow::class);
    }

    public function events(): BelongsToMany {
        return $this->belongsToMany(Event::class);
    }

    public function products(): HasMany {
        return $this->hasMany(Product::class);
    }

    public function reviews() {
        return $this->hasManyThrough(Review::class, Product::class);
    }
}
