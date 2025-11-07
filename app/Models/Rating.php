<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    protected $fillable = [
        'movie_id',
        'user_id', 
        'rating',
        'comment',
    ];

    public function movie()
    {
        return $this->belongsTo(\App\Models\Movie::class);
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
