<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Artwork extends Model
{
    use HasFactory;

    protected $guarded =  [];

    public function image()
    {
        return $this->belongsTo(Image::class);
    }

    public function classification()
    {
        return $this->hasMany(Classification::class);
    }
}
