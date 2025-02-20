<?php

namespace App\Http\Middleware;

use App\Debugger;
use App\Services\SystemService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class InstallerMiddleware
{
    use Debugger;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            if ($this->isLivewireRequest($request)) {
                return $next($request);
            }

            $isInstalled = app(SystemService::class)->isInstalled();

            if ($isInstalled && $this->isInstallRoute($request)) {
                return redirect()->route('dashboard');
            }

            if (!$isInstalled && !$this->isInstallRoute($request)) {
                return redirect()->route('install');
            }

            return $next($request);
        } catch (\Throwable $th) {
            $this->debug('error', 'Unexpected error in installation middleware.', $th);
            throw $th;
        }
    }

    /**
     * Determine if the request is a Livewire request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    private function isLivewireRequest(Request $request): bool
    {
        return $request->is('livewire/*') || $request->header('X-Livewire') || $request->expectsJson() || $request->ajax();
    }

    /**
     * Determine if the request is for an install route.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    private function isInstallRoute(Request $request): bool
    {
        return $request->is('install*');
    }
}
