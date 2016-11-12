<?php
use Silex\Provider\TwigServiceProvider;
use Symfony\Component\HttpFoundation\Request;
use Silex\Provider\AssetServiceProvider;

$app = require '../app.php';

$app->register(new TwigServiceProvider(), [
    'twig.path' => BASEDIR . '/views',
]);

$version = $app['debug'] ? time() : '1.0';
$app->register(new AssetServiceProvider(), [
    'assets.version' => $version,
    'assets.version_format' => '%s?version=%s',
    'assets.named_packages' => [
        'css' => [
            'version' => $version,
            'base_path' => '/css',
        ],
        'js' => [
            'version' => $version,
            'base_path' => '/js',
        ],
    ],
]);

$app->get('/', function () use ($app) {
    return $app['twig']->render('pages/index/index.twig', [
        'commits' => file_get_contents(BASEDIR.'/data/commits.txt'),
        'playtime' => file_get_contents(BASEDIR.'/data/playtime.txt'),
    ]);
});

$app->get('/imprint', function () use ($app) {
    return $app['twig']->render('pages/imprint.twig', []);
});

$app->get('/privacy', function () use ($app) {
    return $app['twig']->render('pages/privacy.twig', []);
});

$app->error(function (\Exception $e, Request $request, $code) use ($app) {
    if (in_array($code, [404])) {
        return $app['twig']->render('errors/' . $code . '.twig', [
            'request' => $request,
            'title' => $code,
        ]);
    }
    return $app['twig']->render('errors/error.twig', [
        'exception' => $e,
        'title' => 'Fehler',
    ]);
});

$app->run();