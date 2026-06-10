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
        // 1. Percayai semua proxy dari Railway
        $middleware->trustProxies(at: '*');

        // 2. PAKSA Laravel membaca header HTTPS dari proxy Railway (Traefik/AWS)
        $middleware->trustProxies(headers: \Illuminate\Http\Request::HEADER_X_FORWARDED_AWS_ELB | \Illuminate\Http\Request::HEADER_X_FORWARDED_TRAEFIK);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
    