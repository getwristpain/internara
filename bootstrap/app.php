<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware
            ->web([
                App\Http\Middleware\EnsureInstalledMiddleware::class
            ])
            ->alias([
                'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
                'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
                'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
            ])
            ->redirectGuestsTo('/login')
            ->redirectUsersTo(function (Request $request) {
                if ($request->user()->hasRole('admin')) {
                    return  url('/admin');
                }

                return url('/dashboard');
            });
        ;
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
