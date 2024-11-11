<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Sanctum\PersonalAccessToken;

class User extends Authenticatable //implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'uuid',
        'email',
        'username',
        'user_type',
        'status',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'id',
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    public function token()
    {
        return $this->hasMany(PersonalAccessToken::class, 'tokenable_id');
    }

    public function socialite(): HasMany
    {
        return $this->has(Socialite::class, "user_uuid", "uuid");
    }

    public function profile(): HasMany
    {
        return $this->has(Profile::class, "user_uuid", "uuid");
    }

    public function draft(): HasMany
    {
        return $this->hasMany(Draft::class, "user_uuid", "uuid");
    }

    public function branch(): HasMany
    {
        return $this->hasMany(Branch::class, "draft_uuid", "uuid");
    }
}
