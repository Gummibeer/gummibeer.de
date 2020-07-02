<?php

namespace App\Http\Controllers\Blog;

use App\Post;
use App\Services\MetaBag;

class IndexController
{
    public function __invoke(MetaBag $meta, int $page = 1)
    {
        $meta->title = 'Blog';

        $posts = Post::all()
            ->paginate($page)
            ->withRoute('blog.index');

        return view('pages.blog.index', compact('posts'));
    }
}
