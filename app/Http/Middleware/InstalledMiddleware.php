<?php

namespace App\Http\Middleware;

use Closure;
use App\Helpers\Debugger;
use App\Services\SettingService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware to handle application installation state.
 */
class InstalledMiddleware
{
    /**
     * The SettingService instance.
     *
     * @var SettingService
     */
    protected SettingService $service;

    /**
     * InstalledMiddleware constructor.
     *
     * @param SettingService $service
     */
    public function __construct(SettingService $service)
    {
        $this->service = $service;
    }

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            if (
                !$this->service->isInstalled() &&
                !$this->isInstallRoute($request) &&
                !$this->isLivewireRequest($request)
            ) {
                return redirect()->route('install.welcome');
            }

            if (
                $this->service->isInstalled() &&
                $this->isInstallRoute($request)
            ) {
                return redirect()->route('auth.login');
            }
        } catch (\Throwable $th) {
            Debugger::handle($th, 'Unexpected error in InstalledMiddleware.', throw: true);
        }

        return $next($request);
    }

    /**
     * Determine if the request is a Livewire request.
     *
     * @param Request $request
     * @return bool
     */
    protected function isLivewireRequest(Request $request): bool
    {
        return $request->is('livewire/*')
            || $request->headers->has('X-Livewire')
            || $request->header('X-Requested-With') === 'livewire:load';
    }

    /**
     * Determine if the request is for an install route.
     *
     * @param Request $request
     * @return bool
     */
    protected function isInstallRoute(Request $request): bool
    {
        return $request->is('install*');
    }
}
