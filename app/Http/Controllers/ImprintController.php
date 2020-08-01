<?php

namespace App\Http\Controllers;

use App\Services\MetaBag;

class ImprintController
{
    public function __invoke(MetaBag $meta)
    {
        $meta->title = 'Imprint';

        return view('pages.imprint')->with(sheets()->get('imprint')->toArray());
    }
}
