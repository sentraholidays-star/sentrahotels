<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Destination extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'hero_image',
        'thumbnail',
        'tagline',
        'description',
        'seo_title',
        'seo_description',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'og_image',
        'is_featured',
        'status',
        'sort_order',
    ];

    protected $casts = [
        'hero_image' => 'array',
        'is_featured' => 'boolean',
        'status' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function hotels()
    {
        return $this->hasMany(Hotel::class)->orderBy('id', 'desc');
    }
}