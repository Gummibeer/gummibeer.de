<?php

namespace App\Providers;

use App\Macros\CollectionMixin;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Traits\Macroable;

class MacroServiceProvider extends ServiceProvider
{
    private const MIXINS = [
        Collection::class => CollectionMixin::class,
    ];

    public function boot(): void
    {
        /** @var Macroable $class */
        foreach (self::MIXINS as $class => $mixin) {
            forward_static_call([$class, 'mixin'], $this->app->make($mixin));
        }
    }
}
