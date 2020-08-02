<?php

use App\Http\Controllers\Blog;
use App\Http\Middleware\Paginated;
use App\Services\MetaBag;
use Illuminate\Support\Facades\Route;
use Spatie\Sitemap\Sitemap;
use Steein\Robots\Robots;

Route::sheet('/', 'pages.home', 'home', function (MetaBag $meta) {
    $meta->description = 'I\'m an enthusiastic web developer and free time gamer from Hamburg, Germany.';
    $meta->image = mix('images/og/static/home.png');
})->name('home');

Route::sheet('/me', 'pages.me', 'me', function (MetaBag $meta) {
    $meta->title = 'Me';
    $meta->description = 'I\'m an enthusiastic web developer and free time gamer from Hamburg, Germany.';
    $meta->image = mix('images/og/static/me.png');
})->name('me');

Route::sheet('/uses', 'pages.uses', 'uses', function (MetaBag $meta) {
    $meta->title = 'Uses';
    $meta->description = 'Software and Tools I use in my daily live for development and some little helpers to improve my experience.';
    $meta->image = mix('images/og/static/uses.png');
})->name('uses');

Route::sheet('/charity', 'pages.charity', 'charity', function (MetaBag $meta) {
    $meta->title = 'Charity';
    $meta->description = 'For me it\'s part of my obligation and responsibility to support what I believe is important for me, us and our planet.';
    $meta->image = mix('images/og/static/charity.png');
})->name('charity');

Route::sheet('/imprint', 'pages.imprint', 'imprint', function (MetaBag $meta) {
    $meta->title = 'Imprint';
})->name('imprint');

Route::sheet('/privacy', 'pages.privacy', 'privacy', function (MetaBag $meta) {
    $meta->title = 'Privacy';
})->name('privacy');

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

Route::get('404.html', fn () => '404')->name('404');
Route::get(
    'sitemap.xml',
    fn () => Sitemap::create()
)->name('sitemap.xml');
Route::get(
    'robots.txt',
    fn () => Robots::getInstance()
        ->userAgent('*')
        ->allow('/')
        ->spacer()
        ->sitemap(route('sitemap.xml'))
        ->render()
)->name('robots.txt');
