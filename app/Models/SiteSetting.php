<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $fillable = [
        'logo_image',
        'favicon_image',
        'navbar_menus',
        'footer_description',
        'footer_address',
        'footer_email',
        'whatsapp_number',
        'is_destination_active',
        'is_news_active',
        'faq_kicker',
        'faq_title',
        'faq_subtitle',
        'seo_meta_title',
        'seo_meta_description',
        'seo_meta_keywords',
        'seo_og_image',
        'social_media_links',
    ];

    protected $casts = [
        'navbar_menus' => 'array',
        'social_media_links' => 'array',
        'is_destination_active' => 'boolean',
        'is_news_active' => 'boolean',
    ];
}
