<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class adminorinternal
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() && (Auth::user()->level == 'admin' || Auth::user()->level == 'internal_reviewer')) {
            return $next($request);
        }
    }
}