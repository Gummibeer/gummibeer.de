<?php

namespace App\Http\Controllers\Blog;

use App\Post;
use App\Services\Feed;

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
