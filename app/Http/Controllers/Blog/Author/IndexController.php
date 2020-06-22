<?php

namespace App\Http\Controllers\Blog\Author;

use App\Author;
use App\Category;
use App\Post;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class IndexController
{
    public function __invoke(Author $author, int $page = 1)
    {
        $posts = $author->posts()
            ->paginate($page)
            ->withRoute('blog.author.index', compact('author'));

        return view('pages.blog', compact('posts'));
    }
}
