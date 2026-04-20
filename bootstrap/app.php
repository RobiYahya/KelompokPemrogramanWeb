<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
<<<<<<< HEAD
        $middleware->alias([
            'admin' => \App\Http\Middleware\IsAdmin::class,
        ]);
=======
        //
>>>>>>> c8ee1291fb9184a643c3c8b56e2912a6f3a04b42
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
