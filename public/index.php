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
    return $app['twig']->render('pages/imprint.twig', [
        'title' => 'Imprint',
    ]);
});

$app->get('/privacy', function () use ($app) {
    return $app['twig']->render('pages/privacy.twig', [
        'title' => 'Privacy',
    ]);
});

$app->error(function (\Exception $e, Request $request, $code) use ($app) {
    switch($code) {
        case 404:
            $title = 'Page not found';
            $message = 'The page you\'ve request isn\'t here.';
            break;
        default:
            $title = 'Server Error';
            $message = 'Sorry, an undefined error occurred.';
            break;
    }
    return $app['twig']->render('errors/error.twig', [
        'exception' => $e,
        'title' => $title,
        'message' => $message,
        'code' => $code,
    ]);
});

$app->run();