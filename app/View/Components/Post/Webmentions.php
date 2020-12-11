<?php

namespace App\View\Components\Post;

use App\Webmentions\Comment;
use App\Webmentions\Like;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\View\Component;

class Webmentions extends Component
{
    public Collection $likes;
    public Collection $comments;

    public function __construct(?string $url = null)
    {
        $url = Str::of($url ?? request()->url())->finish('/');

        $webmentions = collect(Http::get('https://webmention.io/api/mentions.jf2?target='.$url)->json()['children']);

        $this->likes = $webmentions
            ->filter(fn (array $entry): bool => $entry['wm-property'] === 'like-of')
            ->mapInto(Like::class)
            ->sortByDesc('date');

        $this->comments = $webmentions
            ->filter(fn (array $entry): bool => $entry['wm-property'] === 'mention-of')
            ->mapInto(Comment::class)
            ->sortByDesc('date');
    }

    public function render()
    {
        return view('components.post.webmentions');
    }
}
