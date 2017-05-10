<?php
namespace App;

use Carbon\Carbon;
use Github\Api\AbstractApi;
use Github\Client;
use Illuminate\Support\Collection;

class GithubStats extends AbstractApi
{
    protected $me;
    protected $repos = [];
    protected $issues = [];
    protected $comments = [];

    protected $contributions;

    protected $refreshed = [
        'repos' => false,
        'issues' => false,
        'comments' => false,
    ];

    protected static $file = BASEDIR.'/data/github_stats.json';

    public static function make(Client $client)
    {
        $instance = new GithubStats($client);
        if(file_exists(self::$file)) {
            $data = json_decode(file_get_contents(self::$file), true);
            $instance->repos = new Collection($data['repos']);
            $instance->issues = new Collection($data['issues']);
            $instance->comments = new Collection($data['comments']);
        }
        return $instance;
    }

    public function save()
    {
        file_put_contents(self::$file, json_encode([
            'repos' => $this->repos(),
            'issues' => $this->issues(),
            'comments' => $this->comments(),
        ]));
    }

    public function me()
    {
        if(is_null($this->me)) {
            $this->me = $this->get('user');
        }
        return $this->me;
    }

    public function myLogin()
    {
        return $this->me()['login'];
    }

    /**
     * @return Collection
     */
    public function issues()
    {
        if(!($this->issues instanceof Collection) || !$this->refreshed['issues']) {
            $this->issues = new Collection($this->issues);
            $page = 1;
            do {
                $issues = $this->get('search/issues', [
                    'q' => 'involves:' . $this->myLogin(),
                    'per_page' => 100,
                    'page' => $page,
                ]);
                $this->issues = $this->issues->merge($issues['items']);
                $page++;
            } while (count($issues['items']) > 0);
            $this->issues = $this->issues
                ->unique('id')
                ->map(function($issue) {
                    if(!array_key_exists('created_at', $issue)) {
                        return $issue;
                    }
                    $issue['repository'] = $this->getRepoByUrl($issue['repository_url']);
                    $parts = explode('/', $issue['repository']);
                    return [
                        'id' => $issue['id'],
                        'number' => $issue['number'],
                        'comments' => $issue['comments'],
                        'author' => [
                            'id' => $issue['user']['id'],
                            'login' => $issue['user']['login'],
                        ],
                        'assignee' => [
                            'id' => array_get($issue, 'assignee.id'),
                            'login' => array_get($issue, 'assignee.login'),
                        ],
                        'repo' => [
                            'owner' => $parts[0],
                            'repo' => $parts[1],
                        ],
                    ];
                });
            $this->refreshed['issues'] = true;
        }
        return $this->issues;
    }

    /**
     * @return Collection
     */
    public function myIssues()
    {
        $user = $this->me();
        return $this->issues()
            ->filter(function($issue) use ($user) {
                return ($issue['assignee']['id'] == $user['id'] || $issue['author']['id'] == $user['id']);
            });
    }

    /**
     * @return Collection
     */
    public function commentedIssues()
    {
        return $this->issues()
            ->filter(function($issue) {
                return $issue['comments'] > 0;
            });
    }

    /**
     * @return Collection
     */
    public function comments()
    {
        if(!($this->comments instanceof Collection) || !$this->refreshed['comments']) {
            $this->comments = new Collection($this->comments);
            $this->commentedIssues()
                ->each(function($issue) {
                    $page = 1;
                    do {
                        $comments = $this->get('repos/' . rawurlencode($issue['repo']['owner']) . '/' . rawurlencode($issue['repo']['repo']) . '/issues/' . rawurlencode($issue['number']) . '/comments', [
                            'page' => $page,
                        ]);
                        $this->comments = $this->comments->merge($comments);
                        $page++;
                    } while(count($comments) < $issue['comments'] && count($comments) > 0);
                });
            $user = $this->me();
            $this->comments = $this->comments
                ->unique('id')
                ->map(function($comment) {
                    if(!array_key_exists('created_at', $comment)) {
                        return $comment;
                    }
                    $comment['repository'] = $this->getRepoByUrl($comment['url']);
                    $parts = explode('/', $comment['repository']);
                    return [
                        'id' => $comment['id'],
                        'author' => [
                            'id' => $comment['user']['id'],
                            'login' => $comment['user']['login'],
                        ],
                        'repo' => [
                            'owner' => $parts[0],
                            'repo' => $parts[1],
                        ],
                    ];
                })
                ->filter(function($comment) use ($user) {
                    return $comment['author']['id'] == $user['id'];
                });
            $this->refreshed['comments'] = true;
        }
        return $this->comments;
    }

    /**
     * @return Collection
     */
    public function repos()
    {
        if(!($this->repos instanceof Collection) || !$this->refreshed['repos']) {
            $this->repos = new Collection($this->repos);
            $page = 1;
            do {
                $repos = $this->get('user/repos', [
                    'type' => 'all',
                    'page' => $page,
                ]);
                $this->repos = $this->repos->merge($repos);
                $page++;
            } while (count($repos) > 0);
            $this->repos = $this->repos
                ->map(function($repo) {
                    $perPage = 100;

                    $data = $repo;
                    if(array_key_exists('full_name', $repo)) {
                        $parts = explode('/', $repo['full_name']);
                        $data = [
                            'owner' => $parts[0],
                            'repo' => $parts[1],
                        ];
                    }

                    $branches = array_column($this->get('repos/'.rawurlencode($data['owner']).'/'.rawurlencode($data['repo']).'/branches'), 'name');
                    if(array_key_exists('branches', $data)) {
                        $data['branches'] = array_unique(array_merge($data['branches'], $branches));
                    } else {
                        $data['branches'] = $branches;
                    }
                    if(array_key_exists('commits', $data)) {
                        $data['commits'] = new Collection($data['commits']);
                    } else {
                        $data['commits'] = new Collection();
                    }
                    foreach ($data['branches'] as $branch) {
                        $page = 1;
                        do {
                            $commits = $this->get('repos/'.rawurlencode($data['owner']).'/'.rawurlencode($data['repo']).'/commits', [
                                'sha' => $branch,
                                'author' => $this->myLogin(),
                                'since' => (new Carbon(date('Y-m-d H:i:s', 0), 'UTC'))->toIso8601String(),
                                'until' => Carbon::now('UTC')->toIso8601String(),
                                'per_page' => $perPage,
                                'page' => $page,
                            ]);
                            $data['commits'] = $data['commits']->merge(array_column($commits, 'sha'));
                            $page++;
                        } while (count($commits) > 0);
                    }
                    $data['commits'] = $data['commits']
                        ->unique()
                        ->toArray();

                    return $data;
                });
            $this->refreshed['repos'] = true;
        }
        return $this->repos;
    }

    public function contributions()
    {
        if(!is_array($this->contributions)) {
            $contributions = [];

            $this->myIssues()
                ->each(function($issue) use (&$contributions) {
                    $key = $issue['repo']['owner'].'.'.$issue['repo']['repo'].'.issues';
                    $issues = array_get($contributions, $key, []);
                    $issues[] = $issue['id'];
                    array_set($contributions, $key, $issues);
                });

            $this->comments()
                ->each(function($comment) use (&$contributions) {
                    $key = $comment['repo']['owner'].'.'.$comment['repo']['repo'].'.comments';
                    $comments = array_get($contributions, $key, []);
                    $comments[] = $comment['id'];
                    array_set($contributions, $key, $comments);
                });

            $this->repos()
                ->each(function($repo) use (&$contributions) {
                    $key = $repo['owner'].'.'.$repo['repo'].'.commits';
                    $commits = array_get($contributions, $key, []);
                    $commits = array_merge($commits, $repo['commits']);
                    array_set($contributions, $key, $commits);
                });

            $this->contributions = $contributions;
            $this->save();
        }
        return $this->contributions;
    }

    public function contributionsCount()
    {
        $count = 0;
        foreach($this->contributions() as $owner => $repos) {
            foreach($repos as $repo => $details) {
                $count += count(array_get($details, 'commits', []));
                $count += count(array_get($details, 'issues', []));
                $count += count(array_get($details, 'comments', []));
            }
        }
        return $count;
    }

    protected function getRepoByUrl($url)
    {
        $parts = explode('/', trim(str_replace($this->getApiUrl('repos'), '', $url), '/'));
        return implode('/', [
            $parts[0],
            $parts[1],
        ]);
    }

    protected function getApiUrl($path = '')
    {
        $baseUrl = $this->client->getOption('base_url');
        return rtrim($baseUrl, '/').'/'.trim($path, '/');
    }
}