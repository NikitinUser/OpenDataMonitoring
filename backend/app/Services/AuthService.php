<?php

namespace App\Services;

use App\Exceptions\AuthenticateException;
use App\Facades\AuthJwtGuard;
use App\Services\AuthStorage;

class AuthService
{
    public function __construct(private AuthStorage $authStorage)
    {
    }

    /**
     * @param string $login
     * @param string $password
     *
     * @return string
     *
     * @throws AuthenticateException
     */
    public function login(
        string $login,
        string $password,
    ): string {
        if (!$token = $this->attempt($login, $password)) {
            throw new AuthenticateException(trans('errors.auth.bad_credentials'));
        }

        $user = AuthJwtGuard::getUser();

        $this->authStorage->setAuthToken($token, $user);

        return $token;
    }

    /**
     * @return void
     */
    public function logout()
    {
        $this->authStorage->removeAuthToken(AuthJwtGuard::getToken());
        AuthJwtGuard::logout();
    }

    /**
     * @param ?string $token
     *
     * @return bool
     */
    public function existInStorage(?string $token): bool
    {
        if (empty($token)) {
            return false;
        }

        return $this->authStorage->exist($token);
    }

    /**
     * @return string
     */
    public function refresh(): string
    {
        $this->authStorage->removeAuthToken(AuthJwtGuard::getToken());

        $token = AuthJwtGuard::refresh();

        $user = AuthJwtGuard::getUser();

        $this->authStorage->setAuthToken($token, $user);

        return $token;
    }

    /**
     * @param string $login
     * @param string $password
     *
     * @return ?string
     */
    protected function attempt(string $login, string $password)
    {
        $credentials = [
            'email' => $login,
            'password' => $password,
        ];

        if ($token = AuthJwtGuard::attempt($credentials)) {
            return $token;
        }

        return null;
    }
}
