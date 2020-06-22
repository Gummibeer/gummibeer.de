<?php

namespace App\Http\Controllers;

use App\Services\MetaBag;

class HomeController
{
    public function __invoke(MetaBag $meta)
    {
        $meta->description = 'I\'m an enthusiastic web developer and free time gamer from Hamburg, Germany.';

        return view('pages.home');
    }
}
