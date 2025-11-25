<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'title',
        'short_description',
        'long_description',
        'rating',
        'image',
        'trailer_url',
        'release_year',
        'age_rating',
        'runtime',
    ];

     
    //  Get the ratings for the movie
    
    public function ratings()
    {
        return $this->hasMany(\App\Models\Rating::class);
    }

    public function genres()
    {
        return $this->belongsToMany(\App\Models\Genre::class);
    }


     // Accessor for average rating

    public function getAverageRatingAttribute()
    {
        return $this->ratings()->avg('rating') ?? 0;
    }
}
