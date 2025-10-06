<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\Movie;

class MovieCard extends Component
{
    public $movie;

    public function __construct(Movie $movie)
    {
        $this->movie = $movie;
    }

    public function render()
    {
        return view('components.movie-card');
    }
}
