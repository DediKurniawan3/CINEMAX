<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Film extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'poster',
        'genre',
        'duration',
        'synopsis',
        'age_rating',
        'release_date',
        'status',
    ];

    protected $casts = [
        'release_date' => 'date',
    ];

    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class);
    }
}
