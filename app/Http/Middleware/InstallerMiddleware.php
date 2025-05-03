<?php

namespace App\Http\Middleware;

use App\Debugger;
use App\Services\SystemService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class InstallerMiddleware
{
    use Debugger;

    protected SystemService $systemService;

    protected bool $isInstalled = false;

    public function __construct()
    {
        $this->systemService = new SystemService;
        $this->isInstalled = $this->systemService->isInstalled();
    }

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            if (! $this->isInstalled && ! $this->isInstallRoute($request) && ! $this->isLivewireRequest($request)) {
                return redirect()->route('install');
            }

            if ($this->isInstalled && $this->isInstallRoute($request)) {
                if (Auth::check()) {
                    return redirect()->route('dashboard');
                }

                return redirect()->route('login');
            }

            return $next($request);
        } catch (\Throwable $th) {
            $this->debug('error', 'Unexpected error in installation middleware.', $th);
            throw $th;
        }
    }

    /**
     * Determine if the request is a Livewire request.
     */
    private function isLivewireRequest(Request $request): bool
    {
        return $request->is('livewire/*') || $request->header('X-Livewire*') || $request->header('X-Requested-With') === 'livewire:load';
    }

    /**
     * Determine if the request is for an install route.
     */
    private function isInstallRoute(Request $request): bool
    {
        return $request->is('install*');
    }
}
