<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RecommendedHotel extends Model
{
    protected $fillable = [
        'hotel_name',
        'image_id',
        'star_rating',
        'address',
        'city',
        'country',
        'expired_date',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
        'expired_date' => 'date',
    ];

    public function image()
    {
        return $this->belongsTo(\Awcodes\Curator\Models\Media::class, 'image_id');
    }
}
