<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Crop extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'type', 'variety', 'planting_date','address'];

    public function workDays()
    {
        return $this->hasMany(WorkDay::class);
    }

    public function workContents()
    {
        return $this->hasMany(WorkContent::class);
    }

    public function workTimes()
    {
        return $this->hasMany(WorkTime::class);
    }

    public function notes()
    {
        return $this->hasMany(Note::class);
    }

    public function fertilizers()
    {
        return $this->hasMany(Fertilizer::class);
    }

    public function pesticides()
    {
        return $this->hasMany(Pesticide::class);
    }

    public function works()
    {
        return $this->hasMany(Work::class);
    }
}
