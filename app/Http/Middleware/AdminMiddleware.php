<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect('/')->with('error', 'Silakan login terlebih dahulu.');
        }
    
        // Sesuaikan dengan struktur tabel role di database
        if (auth()->user()->role !== 'admin') { // Pastikan role sesuai dengan kolom di database
            return redirect('/home')->with('error', 'Anda tidak memiliki akses ke halaman admin.');
        }
    
        return $next($request);
    }
    
}
