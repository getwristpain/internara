<?php

namespace App\Http\Middleware;

use App\Debugger;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Services\SystemService;

class InstallerMiddleware
{
    use Debugger;

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            if ($request->is('livewire/*') || $request->header('X-Livewire') || $request->expectsJson() || $request->ajax()) {
                return $next($request);
            }

            $isInstalled = app(SystemService::class)->isInstalled();

            // If installed, block access to installation routes
            if ($isInstalled && $request->is('install*')) {
                return redirect()->route('dashboard');
            }

            if (!$isInstalled) {
                // Allow access to the installation route
                if ($request->is('install*')) {
                    return $next($request);
                }

                return redirect()->route('install');
            }

            return $next($request);
        } catch (\Throwable $th) {
            $this->debug('error', 'Unexpected error in installation middleware.', $th);
            throw $th;
        }
    }
}
