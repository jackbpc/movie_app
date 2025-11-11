<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description'];

    // app/Models/Genre.php
    public function movies()
    {
        return $this->belongsToMany(\App\Models\Movie::class, 'genre_movie', 'genre_id', 'movie_id');
    }

}
