<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

/*
|--------------------------------------------------------------------------
| PHP 8.5 Compatibility
|--------------------------------------------------------------------------
| PDO::MYSQL_ATTR_SSL_CA was deprecated in PHP 8.5 in favour of the typed
| constant Pdo\Mysql::ATTR_SSL_CA. The notice bubbles up from inside the
| Laravel framework's own vendor database config. We intercept and silence
| only that specific deprecation until an upstream framework patch ships.
*/
if (PHP_VERSION_ID >= 80500) {
    set_error_handler(static function (int $errno, string $errstr): bool {
        if ($errno === E_DEPRECATED && str_contains($errstr, 'MYSQL_ATTR_SSL_CA')) {
            return true; // handled - do not pass to default handler
        }
        return false;    // everything else uses the default handler
    }, E_DEPRECATED);
}

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
