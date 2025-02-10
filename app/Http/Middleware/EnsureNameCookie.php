<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Symfony\Component\HttpFoundation\Response;

class EnsureNameCookie
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->routeIs('name.page')) {
            if ($request->cookie('name')) {
                return redirect()->route('landing.page');
            }

            return $next($request);
        }

        if (! $request->cookie('name')) {
            Cookie::queue('next', $request->fullUrl(), 5);

            return redirect()->route('name.page');
        }

        return $next($request);
    }
}
