<?php

$app->get('/', function () use ($app) {
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

$app->get('imprint', function () use ($app) {
    return view('pages.imprint')->with([
        'title' => title('Imprint'),
    ]);
});

$app->get('privacy', function () use ($app) {
    return view('pages.privacy')->with([
        'title' => title('Privacy'),
    ]);
});

$app->get('privacy-app', function () use ($app) {
    return view('pages.privacy_app')->with([
        'title' => title('App Privacy'),
    ]);
});
