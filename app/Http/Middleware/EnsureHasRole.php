<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureHasRole
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (! $request->user()) {
            return redirect()->route('login');
        }
        $userRole = $request->user()->role->value;

        if (! in_array($userRole, $roles)) {
            abort(403, 'Akses ditolak. Anda tidak memiliki wewenang untuk halaman ini.');
        }

        return $next($request);
    }
}