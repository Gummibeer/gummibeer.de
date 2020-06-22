<?php

namespace App\View\Components\Post;

use App\Comment;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\View\Component;

class Webmentions extends Component
{
    public Collection $webmentions;

    public function __construct(?string $url = null)
    {
        $url ??= request()->url();
        $this->webmentions = collect(Http::get('https://webmention.io/api/mentions.jf2?target='.$url)->json()['children'])
            ->mapInto(Comment::class)
            ->sortByDesc('date');
    }

    public function render()
    {
        return view('components.post.webmentions');
    }
}
