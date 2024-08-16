<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;
    protected $fillable = [
        'uuid',
        'user_uuid',
        'first_name',
        'last_name',
        'profile',
        'role',
        'biography',
    ];

    protected $hidden = [
        'id',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
