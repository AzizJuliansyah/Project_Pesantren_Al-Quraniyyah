<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // Cek apakah pengguna sudah login
        if (!Auth::check()) {
            // Jika belum login, redirect ke halaman login
            return redirect('login')->with('error', 'Anda harus login terlebih dahulu.');
        }

        // Jika sudah login, lanjutkan request
        return $next($request);
    }
}
