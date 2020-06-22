<?php

namespace App\Http\Controllers\Blog;

use App\Post;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class IndexController
{
    public function __invoke(int $page = 1)
    {
        $posts = Post::all()
            ->paginate($page)
            ->withRoute('blog.index');

        return view('pages.blog', compact('posts'));
    }
}