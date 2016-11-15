<?php
$app = require realpath(__DIR__.'/../app.php');

use Github\Client;
use Github\HttpClient\CachedHttpClient;
use Illuminate\Support\Collection;
use Carbon\Carbon;
use Github\Exception\RuntimeException;

$client = new Client(
    new CachedHttpClient(['cache_dir' => BASEDIR.'/cache'])
);
$client->authenticate(getenv('GH_TOKEN'), null, Client::AUTH_HTTP_TOKEN);


$repos = (new Collection([]))
    ->merge($client->api('me')->repositories('all'))
    ->merge($client->api('me')->repositories('member'))
    ->merge($client->api('me')->repositories('owner'))
    ->merge($client->api('me')->repositories('public'))
    ->merge($client->api('me')->repositories('private'))
    ->unique('full_name')
    ->pluck('full_name', 'full_name')
    ->sort()
    ->map(function ($repo) use ($client) {
        $parts = explode('/', $repo);
        $perPage = 100;
        $repo = [
            'owner' => $parts[0],
            'repo' => $parts[1],
        ];

        $repo['branches'] = array_column($client->api('repo')->branches($parts[0], $parts[1]), 'name');
        $repo['commits'] = new Collection([]);
        foreach ($repo['branches'] as $branch) {
            try {
                $page = 1;
                do {
                    $commits = $client->api('repo')->commits()->all($parts[0], $parts[1], [
                        'sha' => $branch,
                        'author' => getenv('GH_USER'),
                        'since' => (new Carbon(date('Y-m-d H:i:s', 0), 'UTC'))->toIso8601String(),
                        'until' => Carbon::now('UTC')->toIso8601String(),
                        'per_page' => $perPage,
                        'page' => $page,
                    ]);
                    $repo['commits'] = $repo['commits']->merge($commits);
                    $page++;
                } while (count($commits) == $perPage);
            } catch (RuntimeException $e) {
                // ignore
            }
        }
        $repo['commits'] = $repo['commits']->unique('sha')->count();

        return $repo;
    });

file_put_contents(BASEDIR.'/data/commits.txt', $repos->sum('commits'));