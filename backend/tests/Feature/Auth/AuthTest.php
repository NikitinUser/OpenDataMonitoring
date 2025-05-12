<?php

namespace Tests\Feature\Auth;

use Tests\Feature\AuthTrait;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use AuthTrait;

    /**
     * @return void
     */
    public function testApiLoginLogout(): void
    {
        DB::beginTransaction();
        try {
            $loginResponse = $this->sendLogin(self::LOGIN, self::PASS);

            $loginResponse->assertStatus(200);
            $loginResponse->assertJsonStructure([
                0 => 'success',
                'data' => [
                    'token',
                    'expires_at',
                ],
            ]);
            
            $token = $loginResponse->json('data.token');

            $responseLogout = $this
                ->withToken($token)
                ->getJson('/api/auth/logout');

            $responseLogout->assertStatus(200);
            $responseLogout->assertJsonStructure([
                'success',
            ]);

            $responseLogoutSameToken = $this
                ->withToken($token)
                ->getJson('/api/auth/logout');

            $responseLogoutSameToken->assertStatus(401);
        } catch (\Throwable $t) {
            dump($t->getMessage());
            $this->assertTrue(false);
        }

        DB::rollBack();
    }

    /**
     * @return void
     */
    public function testApiLoginFailed(): void
    {
        DB::beginTransaction();
        try {
            $loginResponse = $this->sendLogin(self::LOGIN, 'wrongpass');

            $loginResponse->assertStatus(401);
        } catch (\Throwable $t) {
            dump($t->getMessage());
            $this->assertTrue(false);
        }

        DB::rollBack();
    }

    /**
     * @return void
     */
    public function testApiRefreshSuccess(): void
    {
        DB::beginTransaction();
        try {
            $responseLogin = $this->sendLogin(self::LOGIN, self::PASS);
            $token = $responseLogin->json('data.token');

            $responseLogin->assertStatus(200);
            $responseLogin->assertJsonStructure([
                0 => 'success',
                'data' => [
                    'token',
                    'expires_at',
                ],
            ]);

            $responseRefresh1 = $this
                ->withToken($token)
                ->postJson('/api/auth/refresh');

            $responseRefresh1->assertStatus(200);
            $responseRefresh1->assertJsonStructure([
                0 => 'success',
                'data' => [
                    'token',
                    'expires_at',
                ],
            ]);
        } catch (\Throwable $t) {
            dump($t->getMessage());
            $this->assertTrue(false);
        }

        DB::rollBack();
    }

    /**
     * @return void
     */
    public function testApiRefreshFailed(): void
    {
        DB::beginTransaction();
        try {
            $response = $this
                ->postJson('/api/auth/refresh');
            $response->assertStatus(401);

            $response = $this
                ->withToken('wrongtoken')
                ->postJson('/api/auth/refresh');
            $response->assertStatus(401);
        } catch (\Throwable $t) {
            dump($t->getMessage());
            $this->assertTrue(false);
        }

        DB::rollBack();
    }
}
