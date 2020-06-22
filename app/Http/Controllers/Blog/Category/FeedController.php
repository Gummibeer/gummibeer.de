<?php

namespace App\Http\Controllers\Blog\Category;

use App\Category;
use App\Post;
use App\Services\Feed;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Contracts\Support\Responsable;

class FeedController
{
    public function __invoke(Category $category, string $format)
    {
        return Feed::make(
            $category->slug,
            'Feed of all "'.$category->slug.'" posts.',
            $category->posts(),
            $format
        );
    }
}
