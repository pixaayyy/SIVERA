<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, $role): Response
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        $userRole = strtolower(Auth::user()->role);
        $targetRole = strtolower($role);

        if ($userRole !== $targetRole) {
            
            if ($userRole === 'admin') {
                return redirect('/admin/dashboard')->with('error', 'Anda tidak memiliki akses ke halaman Karyawan.');
            } elseif ($userRole === 'karyawan') {
                return redirect('/karyawan/dashboard')->with('error', 'Anda tidak memiliki akses ke halaman Admin.');
            }

            abort(403, 'Akses Ditolak.');
        }

        return $next($request);
    }
}