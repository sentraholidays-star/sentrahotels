<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TermAndCondition extends Model
{
    protected $fillable = [
        'title',
        'content',
        'images',
    ];

    protected $casts = [
        'images' => 'array',
    ];
}
