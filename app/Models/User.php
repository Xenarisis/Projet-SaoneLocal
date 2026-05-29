<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Follow;
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
        'GoogleToken',
        'lastLogin',
    ];

    protected $hidden = [
        'password',
        'GoogleToken',
        'remember_token',
    ];

    public function getJWTIdentifier() {
        return $this->getKey();
    }

    public function getJWTCustomClaims() {
        return [];
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
}
