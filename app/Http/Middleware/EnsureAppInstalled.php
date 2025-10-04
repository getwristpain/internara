<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAppInstalled
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($this->isAjaxRequest($request)) {
            return $next($request);
        }

        if ($this->isInstalled() && $this->isSetupRoute($request)) {
            return redirect()->route('login');
        }

        if (!$this->isInstalled() && !$this->isSetupRoute($request)) {
            return redirect()->route('setup');
        }

        return $next($request);
    }

    /**
     * Determine if the request is an AJAX request (Livewire or Inertia).
     *
     * @param Request $request
     * @return bool
     */
    protected function isAjaxRequest(Request $request): bool
    {
        return $request->hasHeader('X-Livewire') || $request->hasHeader('X-Inertia');
    }

    /**
     * Determine if the current route is part of the setup process.
     *
     * @param Request $request
     * @return bool
     */
    protected function isSetupRoute(Request $request): bool
    {
        return $request->routeIs('setup*');
    }

    /**
     * Check if the application has been marked as installed in settings.
     *
     * @return bool
     */
    protected function isInstalled(): bool
    {
        return setting('is_installed', default: false);
    }
}
