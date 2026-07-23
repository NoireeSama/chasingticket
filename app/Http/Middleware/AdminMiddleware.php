<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{

    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && (Auth::user()->role === 'admin' || Auth::user()->role === 'merchant')) {
            return $next($request);
        }

        if (Auth::check()) {
            return redirect('/')->with('error', 'Anda tidak memiliki hak akses ke halaman ini.');
        }

        return redirect()->route('admin.login')->with('error', 'Silakan login terlebih dahulu.');
    }
}
