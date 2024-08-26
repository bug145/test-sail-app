<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Validation\ValidationException;
use Throwable;



return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {})
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->renderable(function (Throwable $exception) {
            try {
                $code = $exception->getStatusCode();
            } catch (Throwable $e) {
                $code = 500;
            }

            // Set the status code based on Validation exceptions
            if ($exception instanceof ValidationException) {
                $code = 422;
            }

            return response()->json([
                'success' => false,
                'data' => null,
                'message' => preg_replace('/\s?\[[^\]]*\]\s?/i', ' | ', $exception->getMessage()),
            ], $code);
        });
    })->create();
