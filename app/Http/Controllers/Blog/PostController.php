<?php

namespace App\Http\Controllers\Blog;

use App\Post;
use App\Services\MetaBag;

class PostController
{
    public function __invoke(MetaBag $meta, Post $post)
    {
        $meta->title = $post->title.' | Blog';
        $meta->description = $post->description;

        return view('pages.blog.post', compact('post'));
    }
}
