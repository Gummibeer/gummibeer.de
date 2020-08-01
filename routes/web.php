<?php

use App\Http\Controllers\Blog;
use App\Http\Controllers\HomeController;
use App\Http\Middleware\Paginated;
use Illuminate\Support\Facades\Route;
use Spatie\Sitemap\Sitemap;
use Steein\Robots\Robots;

Route::get('/', HomeController::class)->name('home');
Route::view('/me', 'pages.me', sheets()->get('me')->toArray())->name('me');
Route::view('/uses', 'pages.uses', sheets()->get('uses')->toArray())->name('uses');
Route::view('/charity', 'pages.charity', sheets()->get('charity')->toArray())->name('charity');

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
