<?php

use App\Http\Middleware\Adminmiddleware;
use App\Http\Middleware\Usermiddleware;
use App\Http\Middleware\SetLocale;
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
        // Middleware Aliases
        $middleware->alias([
            'admin' => Adminmiddleware::class,
            'user' => Usermiddleware::class,
        ]);

        // Web Middleware Group এ SetLocale add করুন
        $middleware->web(append: [
            SetLocale::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
