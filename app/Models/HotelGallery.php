<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HotelGallery extends Model
{
    protected $fillable = [
        'hotel_id',
        'image',
        'media_id',
        'sort_order',
    ];

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }

    public function media()
    {
        return $this->belongsTo(\Awcodes\Curator\Models\Media::class, 'media_id');
    }
}
