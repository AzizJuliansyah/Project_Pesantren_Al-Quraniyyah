<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BlockGetOnPostRoutes
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // Cek apakah request menggunakan metode GET pada rute POST
        if ($request->isMethod('get')) {
            return redirect('/')->with('error', 'Akses tidak diizinkan.');
        }

        return $next($request);
    }
}
