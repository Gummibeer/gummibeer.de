<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Spatie\BladeX\BladeX;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
    }

    public function boot()
    {
        $this->getBladeX()->component('slides.components.*');
    }

    protected function getBladeX(): BladeX
    {
        return $this->app->make(BladeX::class);
    }
}
