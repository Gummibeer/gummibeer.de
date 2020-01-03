<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Exception;
use Github\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Cache\Adapter\Redis\RedisCachePool;
use Github\HttpClient\Message\ResponseMediator;
use Github\Exception\RuntimeException as GithubRuntimeException;
use Redis;

class StatsGithub extends Command
{
    protected $name = 'stats:github';
    protected $description = 'Load github statistics.';

    protected $github;

    /**
     * @var Collection
     */
    protected $data;

    public function __construct()
    {
        parent::__construct();

        $client = new Client();
        try {
            $redis = new Redis();
            $config = app('config')->get('database.redis.default');
            $redis->connect($config['host'], $config['port']);
            $client->addCache(new RedisCachePool($redis));
        } catch(Exception $ex) {
        }
        $client->authenticate(getenv('GH_TOKEN'), null, Client::AUTH_HTTP_TOKEN);

        $this->github = $client;
    }

    public function handle()
    {
        $this->load();
        $this->dataCounts();
        $this->line('');

        $this->rateLimit();
        $this->loadRepos();
        $this->dataCounts();
        $this->line('');

        $this->rateLimit();
        $this->loadBranches();
        $this->dataCounts();
        $this->line('');

        $this->rateLimit();
        $this->loadCommits();
        $this->dataCounts();
        $this->line('');

        $this->rateLimit();
        $this->loadIssues();
        $this->dataCounts();
        $this->line('');

        $this->rateLimit();
        $this->loadComments();
        $this->dataCounts();
        $this->line('');

        $this->rateLimit();
        $this->line(sprintf(
            '[<info>%s</info>] total contributions: <comment>%d</comment>',
            getenv('GH_USER'),
            $this->data->pluck('commits.data')->flatten()->count() + $this->data->pluck('issues.data')->flatten()->count() + $this->data->pluck('comments.data')->flatten()->count()
        ));
        $this->save();
    }

    protected function loadComments()
    {
        $this->line('load comments ...');

        $bar = $this->progressBar($this->data->pluck('issues.data')->flatten()->count());
        $this->data = $this->data->map(function ($repo) use ($bar) {
            if (! $repo['exists']) {
                return $repo;
            }
            foreach ($repo['issues']['data'] as $issue) {
                $page = 1;
                do {
                    try {
                        $comments = $this->request('repos/'.rawurlencode($repo['data']['owner']).'/'.rawurlencode($repo['data']['repo']).'/issues/'.rawurlencode($issue).'/comments', [
                            'page' => $page,
                        ]);
                        $comments = array_filter($comments, function ($comment) {
                            return $comment['user']['login'] == getenv('GH_USER');
                        });
                        $repo['comments'] = [
                            'updated_at' => $this->now(),
                            'data' => array_unique(array_merge($repo['comments']['data'], array_column($comments, 'id'))),
                        ];
                        $repo['updated_at'] = $this->now();
                        $page++;
                    } catch (GithubRuntimeException $ex) {
                        $comments = [];
                    }
                } while (count($comments) > 0);
                $bar->advance();
            }
            $repo['updated_at'] = $this->now();

            return $repo;
        });
        $bar->finish();
        $this->line('');
    }

    protected function loadCommits()
    {
        $this->line('load commits ...');

        $bar = $this->progressBar($this->data->pluck('branches.data')->flatten()->count());
        $this->data = $this->data->map(function ($repo) use ($bar) {
            if (! $repo['exists']) {
                return $repo;
            }
            foreach ($repo['branches']['data'] as $branch) {
                $page = 1;
                do {
                    try {
                        $commits = $this->request('repos/'.rawurlencode($repo['data']['owner']).'/'.rawurlencode($repo['data']['repo']).'/commits', [
                            'sha' => $branch,
                            'author' => getenv('GH_USER'),
                            'since' => (new Carbon(date('Y-m-d H:i:s', 0), 'UTC'))->toIso8601String(),
                            'until' => Carbon::now('UTC')->toIso8601String(),
                            'page' => $page,
                        ]);
                        $repo['commits'] = [
                            'updated_at' => $this->now(),
                            'data' => array_unique(array_merge($repo['commits']['data'], array_column($commits, 'sha'))),
                        ];
                        $repo['updated_at'] = $this->now();
                        $page++;
                    } catch (GithubRuntimeException $ex) {
                        $commits = [];
                    }
                } while (count($commits) > 0);
                $bar->advance();
            }
            $repo['updated_at'] = $this->now();

            return $repo;
        });
        $bar->finish();
        $this->line('');
    }

    protected function loadIssues()
    {
        $this->line('load issues ...');

        $page = 1;
        do {
            try {
                $issues = $this->request('search/issues', [
                    'q' => 'involves:'.getenv('GH_USER'),
                    'sort' => 'updated',
                    'order' => 'desc',
                    'page' => $page,
                ])['items'];
                foreach ($issues as $issue) {
                    $name = $this->getRepoByUrl($issue['repository_url']);
                    $this->addRepo($name);
                    $repo = $this->data->get($name);
                    $repo['issues'] = [
                        'updated_at' => $this->now(),
                        'data' => array_unique(array_merge($repo['issues']['data'], [$issue['number']])),
                    ];
                    $repo['updated_at'] = $this->now();
                    $this->data->put($name, $repo);
                }
                $page++;
            } catch (GithubRuntimeException $ex) {
                $issues = [];
            }
        } while (count($issues) > 0);
    }

    protected function loadRepos()
    {
        $this->line('load repos ...');
        $page = 1;
        do {
            $repos = $this->request('user/repos', [
                'type' => 'all',
                'page' => $page,
            ]);
            foreach ($repos as $repo) {
                $this->addRepo($repo['full_name']);
            }
            $page++;
        } while (count($repos) > 0);
    }

    protected function loadBranches()
    {
        $this->line('load branches ...');

        $bar = $this->progressBar($this->data->count());
        $this->data = $this->data->map(function ($repo) use ($bar) {
            if (! $repo['exists']) {
                return $repo;
            }
            try {
                $branches = $this->request('repos/'.rawurlencode($repo['data']['owner']).'/'.rawurlencode($repo['data']['repo']).'/branches');
                $repo['branches'] = [
                    'updated_at' => $this->now(),
                    'data' => array_column($branches, 'name'),
                ];
            } catch (GithubRuntimeException $ex) {
                if ($ex->getCode() == 404) {
                    $repo['exists'] = false;
                }
            }
            $repo['updated_at'] = $this->now();
            $bar->advance();

            return $repo;
        });
        $bar->finish();
        $this->line('');
    }

    protected function rateLimit()
    {
        $rateLimits = $this->github->rateLimit()->getRateLimits()['resources']['core'];
        $this->line(sprintf(
            'limit: <comment>%d</comment> | remaining: <comment>%d</comment> | reset: <comment>%s</comment>',
            $rateLimits['limit'],
            $rateLimits['remaining'],
            Carbon::createFromTimestampUTC($rateLimits['reset'])->toDateTimeString()
        ));
    }

    protected function dataCounts()
    {
        $this->line(sprintf(
            'repos: <comment>%d</comment> | branches: <comment>%d</comment> | commits: <comment>%d</comment> | issues: <comment>%d</comment> | comments: <comment>%d</comment>',
            $this->data->count(),
            $this->data->pluck('branches.data')->flatten()->count(),
            $this->data->pluck('commits.data')->flatten()->count(),
            $this->data->pluck('issues.data')->flatten()->count(),
            $this->data->pluck('comments.data')->flatten()->count()
        ));
    }

    protected function filePath($file)
    {
        $filepath = storage_path('app/stats/'.$file);
        $filedir = dirname($filepath);
        if (! is_dir($filedir)) {
            mkdir($filedir, 0777, true);
        }

        return $filepath;
    }

    protected function load()
    {
        $this->line('load data from file ...');
        $data = [];
        if (file_exists($this->filePath('github.json'))) {
            $data = json_decode(file_get_contents($this->filePath('github.json')), true);
        }
        $this->data = new Collection($data);
    }

    protected function save()
    {
        $this->line('save data to file ...');
        file_put_contents($this->filePath('github.json'), $this->data->toJson());
        file_put_contents($this->filePath('contributions.txt'), $this->data->pluck('commits.data')->flatten()->count() + $this->data->pluck('issues.data')->flatten()->count() + $this->data->pluck('comments.data')->flatten()->count());
    }

    public function request($path, array $parameters = [])
    {
        if (! array_key_exists('per_page', $parameters)) {
            $parameters['per_page'] = 100;
        }
        if (count($parameters) > 0) {
            $path .= '?'.http_build_query($parameters);
        }
        $response = $this->github->getHttpClient()->get($path);

        return ResponseMediator::getContent($response);
    }

    protected function addRepo($name)
    {
        if (! $this->data->has($name)) {
            $this->data->put($name, [
                'updated_at' => $this->now(),
                'exists' => true,
                'data' => [
                    'name' => $name,
                    'owner' => explode('/', $name)[0],
                    'repo' => explode('/', $name)[1],
                ],
                'branches' => [
                    'updated_at' => null,
                    'data' => [],
                ],
                'issues' => [
                    'updated_at' => null,
                    'data' => [],
                ],
                'commits' => [
                    'updated_at' => null,
                    'data' => [],
                ],
                'comments' => [
                    'updated_at' => null,
                    'data' => [],
                ],
            ]);
        }
    }

    protected function now()
    {
        return Carbon::now()->toDateTimeString();
    }

    protected function getRepoByUrl($url)
    {
        $parts = explode('/', trim(str_replace('https://api.github.com/repos/', '', $url), '/'));

        return implode('/', [
            $parts[0],
            $parts[1],
        ]);
    }

    protected function progressBar($count)
    {
        $bar = $this->output->createProgressBar($count);
        if ($count > 0) {
            $bar->setFormat('%current%/%max% [%bar%] %percent:3s%% %elapsed%/%estimated%');
        }
        $bar->setBarCharacter('=');
        $bar->setEmptyBarCharacter(' ');
        $bar->setProgressCharacter('>');

        return $bar;
    }
}
