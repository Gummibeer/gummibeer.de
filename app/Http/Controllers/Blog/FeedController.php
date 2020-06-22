<?php

namespace App\Http\Controllers\Blog;

use App\Post;
use App\Services\Feed;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Contracts\Support\Responsable;

class FeedController
{
    public function __invoke(string $format)
    {
        return Feed::make(
            'Blog',
            'Feed of all blog posts.',
            Post::all(),
            $format
        );
    }
}
