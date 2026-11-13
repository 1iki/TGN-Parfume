<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $user = Auth::user();
        $adminRoles = ['Super Admin', 'Admin', 'Customer Service', 'Marketing', 'Executive'];

        if (!in_array($user->level, $adminRoles)) {
            return redirect()->route('home')->with('error', 'Akses ditolak. Halaman tersebut khusus untuk administrator.');
        }

        return $next($request);
    }
}
