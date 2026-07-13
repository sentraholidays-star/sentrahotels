<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StaticPageSeo extends Model
{
    protected $fillable = [
        'page_identifier',
        'page_name',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'og_image',
    ];

    protected $casts = [
        'meta_keywords' => 'array',
    ];
}
