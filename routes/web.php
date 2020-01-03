<?php

/** @var \Laravel\Lumen\Routing\Router $router */
$router->get('/', function () {
    return view('pages.home')->with([
        'contribute' => file_get_contents(storage_path('app/stats/contributions.txt')),
        'playtime' => file_get_contents(storage_path('app/stats/playtime.txt')),
        'rideDistance' => file_get_contents(storage_path('app/stats/ride_distance.txt')),
        'rideElevation' => file_get_contents(storage_path('app/stats/ride_elevation.txt')),
        'rideTime' => file_get_contents(storage_path('app/stats/ride_time.txt')),
        'packages' => json_decode(file_get_contents(storage_path('app/stats/packagist.json')), true),
        'title' => title(),
        'countries' => selected_countries(),
    ]);
});

$router->get('imprint', function () {
    return view('pages.imprint')->with([
        'title' => title('Imprint'),
    ]);
});

$router->get('privacy', function () {
    return view('pages.privacy')->with([
        'title' => title('Privacy'),
    ]);
});

$router->get('privacy-app', function () {
    return view('pages.privacy_app')->with([
        'title' => title('App Privacy'),
    ]);
});

$router->get('slides/{slide}', function (string $slide) {
    return view('slides.'.\Illuminate\Support\Str::slug($slide, '_'))->with([
        'title' => title(str_replace('-', ' ', $slide).' | Slides'),
    ]);
});

$router->get('blog/{post}', function (string $post) {
    try {
        return view('pages.post')->with([
            'title' => title(str_replace('-', ' ', $post).' | Blog'),
            'content' => file_get_contents(resource_path('posts/'.$post.'.md')),
        ]);
    } catch (Exception $ex) {
        abort(404);
    }
});
