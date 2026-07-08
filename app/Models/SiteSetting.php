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
        'hotel_promo_title',
        'hotel_promo_subtitle',
        'hotel_promo_banners',
        'hotel_brand_promo_banners',
        'recommended_hotel_banners',
        'best_hotel_banners',
        'is_exclusive_rates_active',
    ];

    protected $casts = [
        'navbar_menus' => 'array',
        'social_media_links' => 'array',
        'hotel_promo_banners' => 'array',
        'hotel_brand_promo_banners' => 'array',
        'recommended_hotel_banners' => 'array',
        'best_hotel_banners' => 'array',
        'is_destination_active' => 'boolean',
        'is_news_active' => 'boolean',
        'is_exclusive_rates_active' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::saved(function () {
            \Illuminate\Support\Facades\Cache::forget('global_site_settings');
        });
    }
}
