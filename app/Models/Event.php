<?php

namespace App\Models;

use Database\Factories\EventFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Event extends Model {
    use HasFactory;

    protected $fillable = [
        'event_name',
        'description',
        'event_date',
        'street_line_1',
        'street_line_2',
        'city',
        'postal_code'
    ];

    protected $hidden = [
        'producer_id'
    ];

    protected function casts(): array {
        return [
            'event_date' => 'datetime'
        ];
    }

    public function producers(): BelongsToMany {
        return $this->belongsToMany(Producer::class);
    }
}
