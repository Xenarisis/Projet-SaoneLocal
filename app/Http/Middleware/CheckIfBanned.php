<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckIfBanned {
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response {
        if ((auth()->check() && auth()->user()->is_banned) || (auth('api')->check() && auth('api')->user()->is_banned)) {
            
            if ($request->isMethod('delete') && $request->is('api/users/*')) {
                return $next($request);
            }
            if ($request->isMethod('post') && $request->is('api/users/logout')) {
                return $next($request);
            }

            if ($request->expectsJson()) {
                
                return response()->json([
                    'success' => false,
                    'message' => 'Votre compte a été suspendu par un administrateur.'
                ], 403);
            }

            if ($request->routeIs('banned.page')) {
                return $next($request);
            }
            return redirect()->route('banned.page');
        }

        return $next($request);
    }
}
