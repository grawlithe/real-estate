<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsurePasswordIsReset
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user || ! $user->must_reset_password) {
            return $next($request);
        }

        $resetRoute = route('filament.admin.pages.reset-password');

        if ($request->routeIs('filament.admin.pages.reset-password')) {
            return $next($request);
        }

        return redirect($resetRoute);
    }
}
