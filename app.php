<?php
require realpath('../vendor/autoload.php');

use Dotenv\Dotenv;
use Silex\Application;

define('BASEDIR', realpath(__DIR__));

$dotenv = new Dotenv(BASEDIR);
$dotenv->load();

$app = new Application();
$app['debug'] = getenv('DEBUG');

return $app;