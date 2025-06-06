<?php

namespace App\Http\Middleware;

use Closure;
use App\Helpers\Debugger;
use App\Services\SettingService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class InstalledMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        try {
            if (!app(SettingService::class)->isInstalled() && !$this->isInstallRoute($request) && !$this->isLivewireRequest($request)) {
                return redirect()->route('install');
            }

            if (app(SettingService::class)->isInstalled() && $this->isInstallRoute($request)) {
                return redirect()->route('login');
            }

        } catch (\Throwable $th) {
            Debugger::debug($th, 'Unexpected error in system middleware.', throw: true);
        }

        return $next($request);
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
