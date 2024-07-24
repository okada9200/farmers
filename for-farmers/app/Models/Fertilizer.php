<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fertilizer extends Model
{
    use HasFactory;

    protected $fillable = ['crop_id', 'application_date', 'type', 'amount', 'note'];

    public function crop()
    {
        return $this->belongsTo(Crop::class);
    }
}
