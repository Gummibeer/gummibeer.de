<?php

require_once __DIR__.'/../vendor/autoload.php';

try {
    Dotenv\Dotenv::create(__DIR__.'/../')->load();
} catch (Dotenv\Exception\InvalidPathException $e) {
    //
}

$app = new Laravel\Lumen\Application(
    realpath(__DIR__.'/../')
);

$app->configure('database');

$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    App\Exceptions\Handler::class
);

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    App\Console\Kernel::class
);

$app->register(Illuminate\Redis\RedisServiceProvider::class);

$app->router->group([], function (Laravel\Lumen\Routing\Router $router) {
    require __DIR__.'/../routes/web.php';
});

return $app;
