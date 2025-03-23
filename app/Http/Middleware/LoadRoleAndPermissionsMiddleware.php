<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Context;
use Symfony\Component\HttpFoundation\Response;

class LoadRoleAndPermissionsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            Context::addHidden('permissions', Auth::user()->getAllPermissions());
            Context::addHidden('roles',
                array_map('strtolower', Auth::user()->roles()->withoutGlobalScopes()->get()->pluck('name')->toArray())
            );
        }

        return $next($request);
    }
}
