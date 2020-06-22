<?php

namespace App\Http\Controllers\Blog;

use App\Post;

class IndexController
{
    public function __invoke(int $page = 1)
    {
        $posts = Post::all()
            ->paginate($page)
            ->withRoute('blog.index');

        return view('pages.blog.index', compact('posts'));
    }
}
