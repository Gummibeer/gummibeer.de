<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    public const HOME = '/';

    public function boot(): void
    {
        Route::pattern('year', '[0-9]{4}');
        Route::pattern('page', 'p:([0-9]+)');
        Route::pattern('post', '[0-9]{4}\/[a-z0-9\-]+');

        parent::boot();
    }

    public function map(): void
    {
        Route::middleware('web')
            ->group(base_path('routes/web.php'));
    }
}
