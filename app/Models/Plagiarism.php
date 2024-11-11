<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PlagiarismSources extends Model
{
    use HasFactory;
    protected $fillable = [
        'uuid', 
        'score',
        'title',
        'content',
        'sources',
        'citation',
    ];

}
