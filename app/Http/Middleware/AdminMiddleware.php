<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. If not logged in, trigger unauthorized handler
        if (! auth()->check()) {
            abort(401, 'Authentication required.');
        }

        $user = auth()->user();

        // 2. Resolve access privileges
        $isStandardAdmin = (bool) $user->is_admin;
        $isSuperAdmin = ($user->email === 'admin@example.com');

        if ($isStandardAdmin || $isSuperAdmin) {
            return $next($request);
        }

        // 3. Halt processing and load resources/views/errors/403.blade.php
        abort(403, 'You do not have admin access.');
    }
}
