<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Work extends Model
{
    use HasFactory;

    protected $fillable = ['crop_id', 'work_date', 'work_content', 'work_time', 'note'];

    public function crop()
    {
        return $this->belongsTo(Crop::class);
    }
}
