<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Genre;

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
        // Share unique genres with all views for navigation
        View::composer('*', function ($view) {
            $genres = Genre::orderBy('name')
                ->pluck('name')
                ->unique()   // remove duplicates
                ->values();  // reindex collection

            $view->with('navGenres', $genres);
        });
    }
}
