<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $id = $request->route('id');
        $tokenId = auth()->id();
        $role = auth()->user()->getJWTCustomClaims();

        if ($id != $tokenId && $role !== 'admin') {
            return response()->json('invalid authorization', 401);
        }

        return $next($request);
    }
}
