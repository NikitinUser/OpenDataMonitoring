<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Testing\TestResponse;

trait AuthTrait
{
    private const LOGIN = 'featuretest';
    private const PASS = 'featuretest';

    /**
     * @return void
     */
    public function createUser(): void
    {
        Artisan::call('auth:create-user', [
            'email' => self::LOGIN,
            'password' => self::PASS,
        ]);
    }

    /**
     * @param string $login
     * @param string $pass
     *
     * @return TestResponse
     */
    public function sendLogin(string $login, string $pass): TestResponse
    {
        $this->createUser();

        return $this
            ->postJson('/api/auth/login', [
                'username' => $login,
                'password' => $pass,
            ]);
    }
}
