<?php

use App\Http\Controllers\Blog;
use App\Http\Controllers\HomeController;
use App\Http\Middleware\Beautify;
use App\Http\Middleware\Paginated;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Intervention\Image\Image;
use Intervention\Image\ImageManager;
use Spatie\Browsershot\Browsershot;
use Spatie\Image\Manipulations;
use Steein\Robots\Robots;

Route::get('/', HomeController::class)->name('home');
Route::view('/me', 'pages.me')->name('me');
Route::view('/uses', 'pages.uses', sheets()->collection('static')->get('uses')->toArray())->name('uses');

Route::prefix('blog')->name('blog.')->group(function (): void {
    Route::get('{page?}', Blog\IndexController::class)->middleware(Paginated::class)->name('index');
    Route::get('feed.{format}', Blog\FeedController::class)->name('feed');

    Route::get('{year}/{page?}', fn(Request $request) => $request->route()->parameters())->middleware(Paginated::class)->name('year.index');

    Route::prefix('@{author}')->name('author.')->group(function(): void {
        Route::get('{page?}', Blog\Author\IndexController::class)->middleware(Paginated::class)->name('index');
        Route::get('feed.{format}', Blog\Author\FeedController::class)->name('feed');
    });

    Route::prefix('{category}')->name('category.')->group(function(): void {
        Route::get('{page?}', Blog\Category\IndexController::class)->middleware(Paginated::class)->name('index');
        Route::get('feed.{format}', Blog\Category\FeedController::class)->name('feed');
    });

    Route::get('{post}', Blog\PostController::class)->name('post');
    Route::get('{post}.jpg', [Blog\PostController::class, 'image'])->name('post.jpg');
});

Route::get('404.html', fn() => '404');
Route::get('sitemap.xml', fn() => 'sitemap')->name('sitemap.xml');
Route::get('robots.txt', function () {
    return Robots::getInstance()
        ->userAgent('*')
        ->allow('/')
        ->spacer()
        ->sitemap(route('sitemap.xml'))
        ->render();
});
