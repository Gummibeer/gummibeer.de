<?php

namespace App\Webmentions;

use App\User;
use Astrotomic\LaravelUnavatar\Unavatar;
use Carbon\Carbon;
use Spatie\Sheets\Sheet;

/**
 * @property-read Carbon $date
 * @property-read User $author
 * @property-read string $url
 */
final class Repost extends Sheet
{
    public function getDateAttribute(): Carbon
    {
        return Carbon::make($this['published'] ?? $this['wm-received']);
    }

    public function getAuthorAttribute(array $author): User
    {
        return new User([
            'name' => $author['name'] ?: parse_url($this->url, PHP_URL_HOST),
            'url' => $author['url'] ?: null,
            'avatar' => $author['photo'] ?: Unavatar::domain(parse_url($this->url, PHP_URL_HOST))->toUrl(),
        ]);
    }
}
