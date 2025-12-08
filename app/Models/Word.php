<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Word extends Model
{
    protected $fillable = [
        'word',
    ];

    public function wordBase(): BelongsTo
    {
        return $this->belongsTo(WordBase::class);
    }
}
