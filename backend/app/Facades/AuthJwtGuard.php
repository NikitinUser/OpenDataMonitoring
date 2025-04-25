<?php

namespace App\Facades;

use App\Models\User;
use Tymon\JWTAuth\JWTGuard;

class AuthJwtGuard
{
    /**
     * @return string
     */
    public static function getToken(): string
    {
        /**
         * @var JWTGuard
         */
        $guard = auth('api');

        /** @phpstan-ignore-next-line */
        return $guard->getToken();
    }

    /**
     * @return User
     */
    public static function getUser(): User
    {
        /**
         * @var JWTGuard
         */
        $guard = auth('api');

        /**
         * @var User
         */
        return $guard->getUser();
    }

    /**
     * @return void
     */
    public static function logout(): void
    {
        /**
         * @var JWTGuard
         */
        $guard = auth('api');

        $guard->logout();
    }

    /**
     * @return string
     */
    public static function refresh(): string
    {
        /**
         * @var JWTGuard
         */
        $guard = auth('api');

        return $guard->refresh();
    }

    /**
     * @param array<string> $credentials
     * @param bool $login
     *
     * @return bool|string
     */
    public static function attempt(array $credentials = [], bool $login = true): bool|string
    {
        /**
         * @var JWTGuard
         */
        $guard = auth('api');

        return $guard->attempt($credentials, $login);
    }

    /**
     * @return int
     */
    public static function getTtl(): int
    {
        /**
         * @var JWTGuard
         */
        $guard = auth('api');

        return $guard->factory()->getTTL();
    }
}
