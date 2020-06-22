<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Str;

class Paginated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        preg_match('/'.$request->route()->wheres['page'].'/', $request->route('page'), $hits);
        $request->route()->setParameter('page', intval($hits[1] ?? 1));

        return $next($request);
    }
}
