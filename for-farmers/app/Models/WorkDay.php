<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkDay extends Model
{
    use HasFactory;

    protected $fillable = ['crop_id', 'work_date'];

    public function crop()
    {
        return $this->belongsTo(Crop::class);
    }
}

