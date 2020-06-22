<?php

namespace App\Services;

use Illuminate\Contracts\Routing\UrlRoutable;
use Illuminate\Support\Collection;
use Spatie\Sheets\Sheet;

/**
 * @method static Collection all()
 * @method static static find($identifier)
 */
abstract class Model extends Sheet implements UrlRoutable
{
    public function getRouteKeyName()
    {
    }

    public function resolveRouteBinding($value, $field = null)
    {
        if ($field !== null) {
            return $this->all()->firstWhere($field, $value);
        }

        return $this->find($value);
    }

    public function resolveChildRouteBinding($childType, $value, $field)
    {
        return $this->resolveRouteBinding($value, $field);
    }
}
