<?php

use App\Http\Controllers\Blog;
use App\Http\Controllers\CharityController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ImprintController;
use App\Http\Controllers\MeController;
use App\Http\Controllers\PrivacyController;
use App\Http\Controllers\UsesController;
use App\Http\Middleware\Paginated;
use Illuminate\Support\Facades\Route;
use Spatie\Sitemap\Sitemap;
use Steein\Robots\Robots;

Route::get('/', HomeController::class)->name('home');
Route::get('/me', MeController::class)->name('me');
Route::get('/uses', UsesController::class)->name('uses');
Route::get('/charity', CharityController::class)->name('charity');

Route::get('/imprint', ImprintController::class)->name('imprint');
Route::get('/privacy', PrivacyController::class)->name('privacy');

Route::prefix('blog')->name('blog.')->group(function (): void {
    Route::get('{page?}', Blog\IndexController::class)->middleware(Paginated::class)->name('index');
    Route::get('feed.{format}', Blog\FeedController::class)->name('feed');

    Route::get('{year}/{page?}', Blog\Year\IndexController::class)->middleware(Paginated::class)->name('year.index');

    Route::prefix('@{author}')->name('author.')->group(function (): void {
        Route::get('{page?}', Blog\Author\IndexController::class)->middleware(Paginated::class)->name('index');
        Route::get('feed.{format}', Blog\Author\FeedController::class)->name('feed');
    });

    Route::prefix('{category}')->name('category.')->group(function (): void {
        Route::get('{page?}', Blog\Category\IndexController::class)->middleware(Paginated::class)->name('index');
        Route::get('feed.{format}', Blog\Category\FeedController::class)->name('feed');
    });

    Route::get('{post}', Blog\PostController::class)->name('post');
});

Route::get('404.html', fn () => '404');
Route::get('sitemap.xml', fn () => Sitemap::create())->name('sitemap.xml');
Route::get('robots.txt', function () {
    return Robots::getInstance()
        ->userAgent('*')
        ->allow('/')
        ->spacer()
        ->sitemap(route('sitemap.xml'))
        ->render();
});
