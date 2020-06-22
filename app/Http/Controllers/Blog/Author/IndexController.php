<?php

namespace App\Http\Controllers\Blog\Author;

use App\Author;

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
