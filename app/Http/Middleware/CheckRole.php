<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        // authentication
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        
        $user = auth()->user();

        // is user have one of the required roles
        if (!in_array($user->user_type, $roles)) {
            abort(403, "Unauthorized action. You don't have permission to access this resource.");
        }

        return $next($request);
    }
}
