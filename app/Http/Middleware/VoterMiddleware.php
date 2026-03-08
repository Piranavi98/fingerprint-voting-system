<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VoterMiddleware
{
    public function handle($request, Closure $next)
{
    if (auth()->check() && auth()->user()->role === 'voter') {
        return $next($request);
    }

    return redirect('/login')->with('error', 'Access Denied!');
}
}
