<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Draft extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'uuid',
        'slug',
        'user_uuid',
        'title', 
        'content',
    ];

    protected $hidden = [
        'id',
    ];
    
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, "user_uuid", "uuid");
    }

    public function branch(): HasMany
    {
        return $this->hasMany(Branch::class, "draft_uuid", "uuid");
    }
}

