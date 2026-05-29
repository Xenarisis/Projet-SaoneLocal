<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Follow extends Model {
    use HasFactory;

    protected $fillable = [
        'user_id',
        'producer_id'
    ];

    public function producer(): BelongsTo {
        return $this->belongsTo(Producer::class);
    }

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }
}
