<?php

namespace App\Http\Controllers\Blog\Category;

use App\Category;
use App\Post;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class IndexController
{
    public function __invoke(Category $category, int $page = 1)
    {
        $posts = $category->posts()
            ->paginate($page)
            ->withRoute('blog.category.index', compact('category'));

        return view('pages.blog', compact('posts'));
    }
}
