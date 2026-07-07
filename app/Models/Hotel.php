<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    protected $fillable = [
        'destination_id',
        'name',
        'slug',
        'thumbnail',
        'thumbnail_id',
        'short_description',
        'description',
        'stars',
        'address',
        'latitude',
        'longitude',
        'featured',
        'promotion',
        'status',
        'hotel_type',
        'is_family',
        'is_business',
        'is_beach',
        'is_luxury',
        'why_choose_us',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'og_image',
    ];

    protected $casts = [
        'stars' => 'integer',
        'featured' => 'boolean',
        'promotion' => 'boolean',
        'status' => 'boolean',
        'is_family' => 'boolean',
        'is_business' => 'boolean',
        'is_beach' => 'boolean',
        'is_luxury' => 'boolean',
        'why_choose_us' => 'array',
    ];

    public function destination()
    {
        return $this->belongsTo(Destination::class);
    }

    public function thumbnailImage()
    {
        return $this->belongsTo(\Awcodes\Curator\Models\Media::class, 'thumbnail_id');
    }

    public function galleries()
    {
        return $this->hasMany(HotelGallery::class)->orderBy('sort_order', 'asc');
    }

    public function facilities()
    {
        return $this->hasMany(HotelFacility::class);
    }

    public function rooms()
    {
        return $this->hasMany(HotelRoom::class);
    }

    public function nearbyPlaces()
    {
        return $this->hasMany(NearbyPlace::class);
    }
}
