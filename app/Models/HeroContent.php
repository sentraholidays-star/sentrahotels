<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HeroContent extends Model
{
    protected $fillable = [
        'title',
        'description',
        'introduction',
        'images',
        'alignment',
    ];

    protected $casts = [
        'images' => 'array',
    ];
}
