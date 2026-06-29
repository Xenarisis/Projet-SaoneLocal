<?php

namespace App\Models;

use App\Models\Follow;
use App\Models\CartItem;
use App\Models\Producer;
use App\Models\Bookmark;
use Database\Factories\UserFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Relations\HasMany;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject {
    use HasFactory, Notifiable;

    protected $fillable = [
        'email',
        'firstname',
        'lastname',
        'username',
        'password',
        'google_token',
        'last_login',
        'is_banned',
        'pdp_path',
        'role'
    ];

    protected $hidden = [
        'password',
        'google_token',
        'remember_token',
    ];

    protected function casts(): array {
        return [
            'is_banned' => 'boolean',
            'last_login' => 'datetime',
            'password'  => 'hashed'
        ];
    }

    public function getJWTIdentifier() {
        return $this->getKey();
    }

    public function getJWTCustomClaims() {
        return [
            'role' => $this->role
        ];
    }

    public function isAdmin(): bool {
        return $this->role === 'admin';
    }

    public function producer() {
        return $this->hasOne(Producer::class);
    }

    public function follows(): HasMany {
        return $this->hasMany(Follow::class);
    }

    public function cartItems(): HasMany {
        return $this->hasMany(CartItem::class);
    }

    public function reviews(): HasMany {
        return $this->hasMany(Review::class);
    }

    public function bookmarks(): HasMany {
        return $this->hasMany(Bookmark::class);
    }
}