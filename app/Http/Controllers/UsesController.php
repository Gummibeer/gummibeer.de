<?php

namespace App\Http\Controllers;

use App\Services\MetaBag;

class UsesController
{
    public function __invoke(MetaBag $meta)
    {
        $meta->title = 'Uses';
        $meta->description = 'Software and Tools I use in my daily live for development and some little helpers to improve my experience.';
        $meta->image = mix("images/og/static/uses.png");

        return view('pages.uses')->with(sheets()->get('uses')->toArray());
    }
}
