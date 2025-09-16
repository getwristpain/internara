<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()?->hasRole('student')) {
            return $this->handleStudent($request, $next);
        }

        return $next($request);
    }

    protected function handleStudent(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        if (!$this->isRegistrationRoute($request) && $user->hasStatuses('pending-activation')) {
            return redirect()->route('student.registration');
        }

        return $next($request);
    }

    protected function isRegistrationRoute(Request $request): bool
    {
        return $request->routeIs('student.registration*');
    }
}
