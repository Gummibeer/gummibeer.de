<?php

namespace App;

use App\Repositories\PostRepository;
use App\Services\Model;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Fluent;
use Illuminate\Support\HtmlString;
use Spatie\Feed\Feedable;
use Spatie\Feed\FeedItem;
use Spatie\Sheets\Sheet;

/**
 * @property-read Carbon $date
 * @property-read User $author
 * @property-read string $url
 * @property-read HtmlString $contents
 */
final class Comment extends Sheet
{
    public function getDateAttribute(): Carbon
    {
        return Carbon::make($this['published']);
    }

    public function getAuthorAttribute(array $author): User
    {
        return new User([
            'name' => $author['name'],
            'url' => $author['url'],
            'avatar' => $author['photo'],
        ]);
    }

    public function getContentsAttribute(): HtmlString
    {
        return new HtmlString($this['content']['html']);
    }
}