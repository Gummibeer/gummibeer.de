<?php

namespace App\Http\Controllers\Blog\Author;

use App\Author;
use App\Category;
use App\Post;
use App\Services\Feed;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Contracts\Support\Responsable;

class FeedController
{
    public function __invoke(Author $author, string $format)
    {
        return Feed::make(
            $author->nickname,
            'Feed of all "'.$author->nickname.'" posts.',
            $author->posts(),
            $format
        );
    }
}
