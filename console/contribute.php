<?php
$app = require realpath(__DIR__.'/../app.php');
require realpath(__DIR__.'/GithubStats.php');

use App\GithubStats;
use Github\Client;
use Github\HttpClient\CachedHttpClient;

$client = new Client(
    new CachedHttpClient(['cache_dir' => BASEDIR.'/cache'])
);
$client->authenticate(getenv('GH_TOKEN'), null, Client::AUTH_HTTP_TOKEN);

$github = GithubStats::make($client);

file_put_contents(BASEDIR.'/data/contribute.json', json_encode($github->contributions(), JSON_PRETTY_PRINT));
file_put_contents(BASEDIR.'/data/contribute.txt', $github->contributionsCount());