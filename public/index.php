<?php
use Silex\Application;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\AssetServiceProvider;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

$app = require realpath(__DIR__ . '/../app.php');
if (!($app instanceof Application)) {
    throw new RuntimeException('Failed to create app instance.');
}
$app['version'] = $app['debug'] ? time() : '1.3.4';
$app['cache_path'] = realpath(__DIR__ . '/../cache');

function title($title = '')
{
    return implode(' | ', array_filter([$title, 'Tom Witkowski']));
}

function cacheFile(Request $request, Application $app)
{
    $path = str_slug($request->getPathInfo()) ?: 'home';
    $version = $app['version'];
    $date = date('Ymd');
    $file = str_slug($path . ' ' . $version . ' ' . $date, '_') . '.html';
    return $app['cache_path'] . '/' . $file;
}

$app->before(function (Request $request, Application $app) {
    $path = cacheFile($request, $app);
    if (file_exists($path)) {
        return new Response(file_get_contents($path), 200, [
            'X-Cached' => 'true',
        ]);
    }
    return null;
});

$app->after(function (Request $request, Response $response, Application $app) {
    if (
        $response->headers->has('X-Cached')
        || $response->getStatusCode() != 200
        || $app['debug']
    ) {
        return $response;
    }
    file_put_contents(cacheFile($request, $app), $response->getContent());
    return $response;
});

$app->register(new TwigServiceProvider(), [
    'twig.path' => BASEDIR . '/views',
]);

$app->register(new AssetServiceProvider(), [
    'assets.version' => $app['version'],
    'assets.version_format' => '%s?version=%s',
    'assets.named_packages' => [
        'css' => [
            'version' => $app['version'],
            'base_path' => '/css',
        ],
        'js' => [
            'version' => $app['version'],
            'base_path' => '/js',
        ],
        'img' => [
            'version' => $app['version'],
            'base_path' => '/img',
        ],
    ],
]);

$app->get('/', function () use ($app) {
    return $app['twig']->render('pages/index/index.twig', [
        'commits' => file_get_contents(BASEDIR . '/data/commits.txt'),
        'playtime' => file_get_contents(BASEDIR . '/data/playtime.txt'),
        'title' => title(),
    ]);
});

$app->get('/imprint', function () use ($app) {
    return $app['twig']->render('pages/imprint.twig', [
        'title' => title('Imprint'),
    ]);
});

$app->get('/privacy', function () use ($app) {
    return $app['twig']->render('pages/privacy.twig', [
        'title' => title('Privacy'),
    ]);
});

$app->error(function (\Exception $e, Request $request, $code) use ($app) {
    switch ($code) {
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