<?php

namespace App\Providers;

use Spatie\BladeX\BladeX;
use Illuminate\Support\ServiceProvider;

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
