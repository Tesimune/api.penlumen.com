<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Branch extends Model
{
    use HasFactory;
    protected $fillable = [
        'uuid',
        'slug',
        'user_uuid',
        'draft_uuid',
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

    public function draft(): BelongsTo
    {
        return $this->belongsTo(Draft::class, "draft_uuid", "uuid");
    }
}
