<?php
require realpath(__DIR__.'/vendor/autoload.php');

use Dotenv\Dotenv;
use Silex\Application;

define('BASEDIR', realpath(__DIR__));

$dotenv = new Dotenv(BASEDIR);
$dotenv->load();

$app = new Application();
$app['debug'] = getenv('DEBUG');

return $app;