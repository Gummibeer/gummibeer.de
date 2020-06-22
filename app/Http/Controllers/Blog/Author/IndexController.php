<?php

namespace App\Http\Controllers\Blog\Author;

use App\Author;
use App\Services\MetaBag;

class IndexController
{
    public function __invoke(MetaBag $meta, Author $author, int $page = 1)
    {
        $meta->title = sprintf('Blog posts written by %s', $author->name);

        $posts = $author->posts()
            ->paginate($page)
            ->withRoute('blog.author.index', compact('author'));

        return view('pages.blog.author', compact('author', 'posts'));
    }
}
