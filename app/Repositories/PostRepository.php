<?php

namespace App\Repositories;

use App\Post;
use Illuminate\Support\Collection;

class PostRepository
{
    public function all(): Collection
    {
        return sheets()->collection('posts')->all()
            ->reject(fn (Post $post) => $post->date->isFuture())
            ->sortByDesc('date');
    }

    public function latest(): Post
    {
        return $this->all()->first();
    }

    public function find(string $slug): Post
    {
        [$year, $slug] = explode('/', $slug);

        return $this->all()
            ->first(fn (Post $post): bool => $post->date->year == $year && $post->slug == $slug);
    }
}
