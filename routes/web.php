<?php

function title($title = '') {
    return implode(' | ', array_filter([trim($title), 'Tom Witkowski']));
}

$app->get('/', function () use ($app) {
    return view('pages.home')->with([
        'contribute' => file_get_contents(storage_path('app/stats/contributions.txt')),
        'playtime' => file_get_contents(storage_path('app/stats/playtime.txt')),
        'title' => title(),
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
