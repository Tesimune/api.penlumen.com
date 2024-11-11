<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Publish extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'slug',
        'user_id',
        'title',
        'content',
        'description'
    ];

    protected $hidden = [
        'id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
