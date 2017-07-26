<?php
$app = require realpath(__DIR__.'/../app.php');
require realpath(__DIR__.'/GithubStats.php');

use App\GithubStats;
use Github\Client;
use Github\HttpClient\CachedHttpClient;

class FilesystemLevelCache extends \Github\HttpClient\Cache\FilesystemCache
{
    protected function getPath($id)
    {
        $hash = hash('md5', $id);
        $folder = implode(DIRECTORY_SEPARATOR, [
            rtrim($this->path, DIRECTORY_SEPARATOR),
            substr($hash, 0, 2),
        ]);
        if (!file_exists($folder)) {
            mkdir($folder, 0777, true);
        }
        return implode(DIRECTORY_SEPARATOR, [
            $folder,
            $hash,
        ]);
    }
}

$cacheDir = BASEDIR.'/cache/github/';
$cache = new FilesystemLevelCache($cacheDir);
$httpClient = new CachedHttpClient(['cache_dir' => $cacheDir]);
$httpClient->setCache($cache);

$client = new Client($httpClient);
$client->authenticate(getenv('GH_TOKEN'), null, Client::AUTH_HTTP_TOKEN);

echo json_encode($client->rateLimit()->getRateLimits()['rate'], JSON_PRETTY_PRINT).PHP_EOL;

$github = GithubStats::make($client);

if(array_key_exists(1, $argv) && (substr($argv[1], 0, 7) === '--only=')) {
    $refresh = trim(str_replace('--only=', '', $argv[1]));
} elseif(date('H') % 4 == 0) {
    $refresh = 'repos';
} elseif(date('H') % 3 == 0) {
    $refresh = 'issues';
} else {
    $refresh = 'comments';
}
echo 'only refresh: '.$refresh.PHP_EOL;
$github->singleRefresh($refresh);

file_put_contents(BASEDIR.'/data/contribute.json', json_encode($github->contributions(), JSON_PRETTY_PRINT));
file_put_contents(BASEDIR.'/data/contribute.txt', $github->contributionsCount());