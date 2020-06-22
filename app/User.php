<?php

namespace App;

use App\Repositories\AuthorRepository;
use App\Repositories\PostRepository;
use App\Services\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Fluent;
use Illuminate\Support\Str;
use Spatie\Sheets\Sheet;

/**
 * @property-read string $name
 * @property-read string $url
 * @property-read string $avatar
 */
final class User extends Sheet
{
}