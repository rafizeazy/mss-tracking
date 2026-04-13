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
        $userRole = $request->user()->role instanceof \App\Enums\Role
            ? strtolower($request->user()->role->value)
            : strtolower((string) $request->user()->role);

        $allowed = array_map(fn ($r) => strtolower((string) $r), $roles);

        if (! in_array($userRole, $allowed, true)) {
            abort(403, 'Akses ditolak. Anda tidak memiliki wewenang untuk halaman ini.');
        }

        return $next($request);
    }
}