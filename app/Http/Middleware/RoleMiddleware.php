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
        $routeId = (int) $request->route('id');
        $user = auth()->user();

        if (!$user) {
            return response()->json('not authenticated', 401);
        }

        $tokenId = $user->id;
        $role = $user->getJWTCustomClaims()['role'] ?? null;

        if ($routeId !== $tokenId && $role !== 'admin') {
            return response()->json('invalid authorization', 403);
        }

        return $next($request);
    }
}
