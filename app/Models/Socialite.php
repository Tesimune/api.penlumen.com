<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Socialite extends Model
{
    use HasFactory;

    protected $fillable = [
        "uuid",
        "user_uuid",
        "socialite",
        "email",
        "token",
        "auth_data",
    ];

    protected $hidden = [
        'id',
    ];

    protected $casts = [
        "auth_data" => "array",
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
