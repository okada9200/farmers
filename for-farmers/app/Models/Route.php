<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    protected $fillable = ['start', 'destinations'];

    protected $casts = [
        'destinations' => 'array',
    ];
}
