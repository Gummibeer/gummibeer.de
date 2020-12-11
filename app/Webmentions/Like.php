<?php

namespace App\Webmentions;

use App\User;
use Carbon\Carbon;
use Spatie\Sheets\Sheet;

/**
 * @property-read Carbon $date
 * @property-read User $author
 */
final class Like extends Sheet
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
}
