<?php

namespace App\Http\Controllers\Blog\Category;

use App\Category;

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
