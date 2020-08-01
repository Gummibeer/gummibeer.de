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
        $meta->image = route('blog.post.jpg', $post);

        return view('pages.blog.post', compact('post'));
    }

    public function image(ImageManager $manager, Post $post)
    {
        $html = view('post.og_image', compact('post'))->render();
        $filepath = storage_path('app/og-image/'.$post->slug.'.jpg');

        Browsershot::html($html)
            ->windowSize(1200, 630)
            ->deviceScaleFactor(2)
            ->setScreenshotType('jpeg', 100)
            ->fit(Manipulations::FIT_CONTAIN, 1200, 630)
            ->save($filepath);

        return $manager
            ->make($filepath)
            ->response();
    }
}
