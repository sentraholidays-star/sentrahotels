<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class B2bInfo extends Model
{
    protected $fillable = [
        'hero_title',
        'title',
        'description',
        'images',
        'join_us_hero_image',
        'join_us_title',
        'join_us_description',
        'join_us_requirements',
    ];

    protected $casts = [
        'images' => 'array',
        'join_us_requirements' => 'array',
    ];
}
