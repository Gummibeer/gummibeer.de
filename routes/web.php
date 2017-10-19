<?php

function title($title = '') {
    return implode(' | ', array_filter([trim($title), 'Tom Witkowski']));
}

$app->get('/', function () use ($app) {
    return view('pages.home')->with([
        'contribute' => file_get_contents(storage_path('app/stats/contributions.txt')),
        'playtime' => file_get_contents(storage_path('app/stats/playtime.txt')),
        'rideDistance' => file_get_contents(storage_path('app/stats/ride_distance.txt')),
        'rideElevation' => file_get_contents(storage_path('app/stats/ride_elevation.txt')),
        'rideTime' => file_get_contents(storage_path('app/stats/ride_time.txt')),
        'title' => title(),
        'countries' => [
            'BG' => 'Bulgaria',
            'CZ' => 'Czechia',
            'DE' => 'Germany',
            'ES' => 'Spain',
            'FR' => 'France',
            'PL' => 'Poland',
        ],
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