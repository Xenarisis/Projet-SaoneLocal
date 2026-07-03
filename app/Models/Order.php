<?php

namespace App\Models;

use Database\Factories\OrderFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Order extends Model {
    use HasFactory;

    protected $fillable = [
        'order_number',
        'status',
        'total_excl_tax',
        'percentage_tax',
        'payment_status'
    ];

    protected $hidden = [
        'user_id'
    ];

    protected function casts(): array {
        return [
            'total_excl_tax' => 'decimal:2',
            'percentage_tax' => 'decimal:2'
        ];
    }

    public function discounts(): BelongsToMany {
        return $this->belongsToMany(Discount::class, 'reduces');
    }

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany {
        return $this->hasMany(OrderItem::class);
    }
}
