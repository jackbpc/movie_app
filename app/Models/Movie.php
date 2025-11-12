<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;
    /**
     * Get the ratings for the movie.
     */
    public function ratings()
    {
        return $this->hasMany(\App\Models\Rating::class);
    }

    // app/Models/Movie.php
    public function genres()
    {
        return $this->belongsToMany(Genre::class);
    }




    public function getAverageRatingAttribute()
    {
        return $this->ratings()->avg('rating') ?? 0;
    }

}
