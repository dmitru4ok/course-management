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
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // dd(auth('api')->user()->role->value);
        if (in_array(auth('api')->user()->role_name, explode('|', $role))) {
            return $next($request);
        }
        return response(['message' => 'No privilege to access this resource'], 403);
    }
}
