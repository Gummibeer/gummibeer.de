<?php

namespace App\Webmentions;

use App\Repositories\AuthorRepository;
use App\Services\Model;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;
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
