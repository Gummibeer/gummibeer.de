<?php

namespace Illuminate\Support {
    abstract class Collection {
        abstract public function paginate(?int $page = null, int $perPage = 3, array $options = []): \App\Services\Paginator;
    }
}