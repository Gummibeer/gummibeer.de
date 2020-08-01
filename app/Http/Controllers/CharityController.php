<?php

namespace App\Http\Controllers;

use App\Services\MetaBag;

class CharityController
{
    public function __invoke(MetaBag $meta)
    {
        $meta->title = 'Charity';
        $meta->description = 'For me it\'s part of my obligation and responsibility to support what I believe is important for me, us and our planet.';
        $meta->image = mix("images/og/static/charity.png");

        return view('pages.charity')->with(sheets()->get('charity')->toArray());
    }
}
