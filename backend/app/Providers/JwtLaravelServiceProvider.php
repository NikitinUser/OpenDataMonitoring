<?php

namespace App\Providers;

use App\Http\Middleware\JwtAuthMiddleware;
use Tymon\JWTAuth\Http\Middleware\AuthenticateAndRenew;
use Tymon\JWTAuth\Http\Middleware\Check;
use Tymon\JWTAuth\Http\Middleware\RefreshToken;
use Tymon\JWTAuth\Providers\LaravelServiceProvider;

class JwtLaravelServiceProvider extends LaravelServiceProvider
{
    /**
     * The middleware aliases.
     *
     * @var array<string>
     */
    protected $middlewareAliases = [
        'jwt.auth' => JwtAuthMiddleware::class,
        'jwt.check' => Check::class,
        'jwt.refresh' => RefreshToken::class,
        'jwt.renew' => AuthenticateAndRenew::class,
    ];
}
