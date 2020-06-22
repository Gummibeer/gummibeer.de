<?php

namespace App\Providers;

use App\Category;
use App\Post;
use Illuminate\Support\ServiceProvider;
use Spatie\Export\Exporter;

class ExportServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->app->booted(fn () => $this->app->call([$this, 'booted']));
        }
    }

    public function booted(Exporter $exporter): void
    {
        Post::all()
            ->each(function (Post $post) use ($exporter): void {
                $exporter
                    ->urls($post->url, route('blog.post.jpg', $post))
                    ->urls(route('blog.year.index', ['year' => $post->date->year]))
                    ->urls([
                        $post->author->url,
                        route('blog.author.feed', ['author' => $post->author, 'format' => 'rss']),
                        route('blog.author.feed', ['author' => $post->author, 'format' => 'atom']),
                    ])
                    ->urls(
                        collect($post->categories())
                            ->map(function (Category $category) {
                                return [
                                    $category->url,
                                    route('blog.category.feed', ['category' => $category, 'format' => 'rss']),
                                    route('blog.category.feed', ['category' => $category, 'format' => 'atom']),
                                ];
                            })
                            ->flatten()
                            ->all()
                    );
            });
    }
}
