<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HowWeWork extends Model
{
    protected $fillable = [
        'hero_image',
        'title_content',
        'description',
        'faqs',
    ];

    protected $casts = [
        'faqs' => 'array',
    ];
}
