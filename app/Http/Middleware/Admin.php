<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (null === $request->user() || 'admin' !== $request->user()->login) {
            return redirect()->route('home.index')
                ->with('error', 'You don\'t have access to this site!');
        }

        return $next($request);
    }
}
