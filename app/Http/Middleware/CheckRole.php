<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

// Membatasi halaman berdasarkan role. Contoh pemakaian di rute: 'role:admin,petugas'
class CheckRole
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        if ($user && in_array($user->role, $roles, true)) {
            return $next($request);
        }

        // Role tidak cocok: kembalikan ke halaman awal miliknya sendiri.
        // Kalau ternyata sudah berada di halaman awal itu, tolak saja (mencegah redirect berulang).
        if ($user && ! $request->routeIs($user->halamanAwal())) {
            return redirect()->route($user->halamanAwal())
                ->with('gagal', 'Anda tidak punya akses ke halaman tersebut.');
        }

        abort(403, 'Anda tidak punya akses ke halaman ini.');
    }
}
