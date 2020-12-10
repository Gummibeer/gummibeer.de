<?php

namespace App\Macros;

use App\Services\Paginator;
use Closure;
use Illuminate\Support\Collection;

/** @mixin Collection */
final class CollectionMixin
{
    public function paginate(): Closure
    {
        return function (?int $page = null, int $perPage = 3, array $options = []): Paginator {
            return Paginator::make($this, $perPage, $page, $options);
        };
    }
}
