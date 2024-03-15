<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $guarded =  [];

    public function Artwork()
    {
        return $this->hasMany(Artwork::class);
    }
}
