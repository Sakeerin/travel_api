<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {

        // if(! Auth::check()){
        //     abort(401, 'Unauthorized');
        // }

        if ($request->user()->check() == false) {
            abort(401, 'Unauthorized');
        }

        // if(! Auth::user()->roles->where('name', $role)->exists()){
        //     abort(403, ' Forbidden');
        // }

        if ($request->user()->roles()->where('name', $role)->exists()) {
            abort(403, ' Forbidden');
        }

        return $next($request);
    }
}
