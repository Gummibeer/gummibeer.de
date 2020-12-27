<?php

namespace App\Providers;

use App\Author;
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
            $this->app->booted(function (): void {
                $exporter = $this->app->make(Exporter::class);

                $exporter->urls([
                    route('blog.feed', ['format' => 'rss']),
                    route('blog.feed', ['format' => 'atom']),
                ]);

                Category::all()->each(fn (Category $category) => $exporter->urls([
                    $category->url,
                    route('blog.category.feed', ['category' => $category, 'format' => 'rss']),
                    route('blog.category.feed', ['category' => $category, 'format' => 'atom']),
                ]));

                Author::all()->each(fn (Author $author) => $exporter->urls([
                    $author->url,
                    route('blog.author.feed', ['author' => $author, 'format' => 'rss']),
                    route('blog.author.feed', ['author' => $author, 'format' => 'atom']),
                ]));

                Post::all()->each(fn (Post $post) => $exporter->urls(
                    route('blog.year.index', ['year' => $post->date->year])
                ));
            });
        }
    }
}
