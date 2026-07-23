<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class SuperAdminMiddleware
{

    public function handle(Request $request, Closure $next): Response
    {

        if (Auth::check() && Auth::user()->role === 'admin') {
            return $next($request);
        }

        if (Auth::check() && Auth::user()->role === 'merchant') {
            return redirect()->route('admin.dashboard')->with('error', 'Akses ditolak. Merchant tidak dapat mengakses halaman ini.');
        }

        return redirect()->route('admin.login')->with('error', 'Silakan login terlebih dahulu.');
    }
}
