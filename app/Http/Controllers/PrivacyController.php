<?php

namespace App\Http\Controllers;

use App\Services\MetaBag;

class PrivacyController
{
    public function __invoke(MetaBag $meta)
    {
        $meta->title = 'Privacy';

        return view('pages.privacy')->with(sheets()->get('privacy')->toArray());
    }
}
