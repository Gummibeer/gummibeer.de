<?php

namespace App\View\Components\Post;

use App\Webmentions\Comment;
use App\Webmentions\Like;
use App\Webmentions\Repost;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\View\Component;

class Webmentions extends Component
{
    public Collection $likes;
    public Collection $reposts;
    public Collection $comments;

    public function __construct(?string $url = null)
    {
        $url ??= request()->url();

        $webmentions = collect();
        $page = 0;
        do {
            $entries = Http::get('https://webmention.io/api/mentions.jf2', [
                'token' => config('services.webmention.token'),
                'domain' => parse_url($url, PHP_URL_HOST),
                'per-page' => 100,
                'page' => $page,
            ])->json()['children'] ?? [];
            $webmentions->push(...$entries);

            $page++;
        } while (count($entries) >= 100);

        $webmentions = $webmentions
            ->filter(fn (array $entry): bool => trim(parse_url($entry['wm-target'], PHP_URL_PATH), '/') === trim(parse_url($url, PHP_URL_PATH), '/'));

        $this->likes = $webmentions
            ->filter(fn (array $entry): bool => $entry['wm-property'] === 'like-of')
            ->mapInto(Like::class)
            ->sortByDesc('date');

        $this->reposts = $webmentions
            ->filter(function (array $entry): bool {
                if ($entry['wm-property'] === 'repost-of') {
                    return true;
                }

                if ($entry['wm-property'] === 'mention-of') {
                    return empty($entry['content']['text']);
                }

                return false;
            })
            ->mapInto(Repost::class)
            ->sortByDesc('date');

        $this->comments = $webmentions
            ->filter(fn (array $entry): bool => in_array($entry['wm-property'], ['mention-of', 'in-reply-to']))
            ->reject(fn (array $entry): bool => empty($entry['content']['text']))
            ->mapInto(Comment::class)
            ->sortBy('date');
    }

    public function render()
    {
        return view('components.post.webmentions');
    }
}
