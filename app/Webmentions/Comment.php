<?php

namespace App\Webmentions;

use App\User;
use Carbon\Carbon;
use Illuminate\Support\HtmlString;
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
        return Carbon::make($this['published'] ?? $this['wm-received']);
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
        return new HtmlString(nl2br($this['content']['html']));
    }
}
