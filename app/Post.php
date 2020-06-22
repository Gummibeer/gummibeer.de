<?php

namespace App;

use App\Repositories\PostRepository;
use App\Services\Model;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Spatie\Feed\Feedable;
use Spatie\Feed\FeedItem;

/**
 * @property-read string $title
 * @property-read string $image
 * @property-read string[] $categories
 * @property-read Carbon $date
 * @property-read Carbon $modified_at
 * @property-read string $contents
 * @property-read float $read_time
 * @property-read Author $author
 * @property-read string $description
 * @property-read string $slug
 * @property-read string $url
 *
 * @method static Collection|Post[] all()
 * @method static Post latest()
 * @method static Post find(int $year, string $slug)
 */
final class Post extends Model implements Feedable
{
    /**
     * @return Collection|Category[]
     */
    public function categories(): Collection
    {
        return collect($this->categories)
            ->map(fn (string $slug): array => ['slug' => $slug])
            ->mapInto(Category::class);
    }

    public function getRouteKey()
    {
        return $this->date->year.'/'.$this->slug;
    }

    public function getAuthorAttribute(string $nickname): Author
    {
        return Author::find($nickname);
    }

    public function getReadTimeAttribute(): float
    {
        $wordCount = mb_strlen(strip_tags($this->contents)) / 5;
        $wordsPerMinute = 60 * 3;
        $minutes = ceil(($wordCount / $wordsPerMinute) * 2) / 2;

        return max(1, $minutes);
    }

    public function getUrlAttribute(): string
    {
        return route('blog.post', $this);
    }

    public function getModifiedAtAttribute(): Carbon
    {
        return Carbon::createFromTimestamp(filemtime(resource_path('content/posts/'.$this->path)), 'UTC');
    }

    public function toFeedItem(): FeedItem
    {
        return FeedItem::create()
            ->id($this->url)
            ->title($this->title)
            ->author($this->author)
            ->summary($this->description)
            ->updated($this->date)
            ->link($this->url)
            ->category(...$this->categories);
    }

    public function __call($name, $arguments)
    {
        return call_user_func_array([app(PostRepository::class), $name], $arguments);
    }

    public static function __callStatic($name, $arguments)
    {
        return call_user_func_array([app(PostRepository::class), $name], $arguments);
    }
}
