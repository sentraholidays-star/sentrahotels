<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HotelRoom extends Model
{
    protected $fillable = [
        'hotel_id',
        'room_name',
        'image',
        'media_id',
        'description',
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
