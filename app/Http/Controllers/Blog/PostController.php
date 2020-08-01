<?php

namespace App\Http\Controllers\Blog;

use App\Post;
use App\Services\MetaBag;
use Intervention\Image\ImageManager;
use Spatie\Browsershot\Browsershot;
use Spatie\Image\Manipulations;

class PostController
{
    public function __invoke(MetaBag $meta, Post $post)
    {
        $meta->title = $post->title.' | Blog';
        $meta->description = $post->description;

        return view('pages.blog.post', compact('post'));
    }
}
