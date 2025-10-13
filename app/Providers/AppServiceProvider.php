<?php

namespace App\Providers;
use App\Models\Movie;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
{
    // Share all distinct genres with all views
    $genres = Movie::select('genre')->distinct()->pluck('genre');
    View::share('genres', $genres);
}
}
