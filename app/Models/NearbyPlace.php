<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NearbyPlace extends Model
{
    protected $table = 'nearby_places';

    protected $fillable = [
        'hotel_id',
        'place_name',
        'distance',
    ];

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }
}
