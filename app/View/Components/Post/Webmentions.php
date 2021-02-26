<?php

namespace App\View\Components\Post;

use Illuminate\Support\Collection;
use Illuminate\View\Component;

class Webmentions extends Component
{
    public Collection $likes;
    public Collection $reposts;
    public Collection $comments;

    public function __construct(?string $url = null)
    {
        $url ??= request()->url();

        $this->likes = \Astrotomic\Webmentions\Facades\Webmentions::likes($url)
            ->sortByDesc('created_at');

        $this->reposts = \Astrotomic\Webmentions\Facades\Webmentions::reposts($url)
            ->sortByDesc('created_at');

        $this->comments = \Astrotomic\Webmentions\Facades\Webmentions::mentions($url)
            ->concat(\Astrotomic\Webmentions\Facades\Webmentions::replies($url))
            ->sortBy('created_at');
    }

    public function render()
    {
        return view('components.post.webmentions');
    }
}
