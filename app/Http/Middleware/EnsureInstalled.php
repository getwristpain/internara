<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureInstalled
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!setting()->isInstalled() && !$this->isInstallRoute($request) && !$this->isLivewireRequest($request)) {
            return redirect()->route('setup');
        }

        if (setting()->isInstalled() && $this->isInstallRoute($request)) {
            return redirect()->route('login');
        }

        return $next($request);
    }

    protected function isInstallRoute(Request $request): bool
    {
        return $request->routeIs('setup*');
    }

    protected function isLivewireRequest(Request $request): bool
    {
        return $request->is('livewire/*')
            || $request->headers->has('X-Livewire')
            || $request->header('X-Requested-With') === 'livewire:load';
    }
}
