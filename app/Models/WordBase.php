<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WordBase extends Model
{
    protected $fillable = [
        'name',
        'url',
    ];

    public function words(): HasMany
    {
        return $this->hasMany(Word::class);
    }
}
