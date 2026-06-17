<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders {
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response {
        $response = $next($request);

        $csp =  "default-src 'self'; " .
                "script-src 'self'; " .
                "connect-src 'self' http://localhost:8000; " .
                "img-src 'self' data:; " .
                "style-src 'self' 'unsafe-inline';";

        $response->headers->set('Content-Security-Policy', $csp);

        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('X-Frame-Options', 'DENY');

        return $response;
    }
}
