<?php

use App\Http\Middleware\SetAuthGuard;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'auth.guard' => App\Http\Middleware\RedirectIfNotAuthenticated::class

        ]);
        $middleware->append(SetAuthGuard::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
