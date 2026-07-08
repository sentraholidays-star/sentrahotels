<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExclusiveRate extends Model
{
    protected $fillable = [
        'title',
        'image_id',
        'url_link',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function image()
    {
        return $this->belongsTo(\Awcodes\Curator\Models\Media::class, 'image_id');
    }
}
