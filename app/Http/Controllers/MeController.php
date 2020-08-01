<?php

namespace App\Http\Controllers;

use App\Services\MetaBag;

class MeController
{
    public function __invoke(MetaBag $meta)
    {
        $meta->title = 'Me';
        $meta->description = 'I\'m an enthusiastic web developer and free time gamer from Hamburg, Germany.';
        $meta->image = mix("images/og/static/me.png");

        return view('pages.me')->with(sheets()->get('me')->toArray());
    }
}
