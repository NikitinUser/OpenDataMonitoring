<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Redis\RedisManager;

class AuthStorage
{
    private const AUTH_TOKEN_KEY = 'credentials.auth_token.%s';

    /**
     * @param RedisManager $redisManager
     */
    public function __construct(private RedisManager $redisManager)
    {
    }

    /**
     * @param string $token
     * @param User $user
     *
     * @return bool
     */
    public function setAuthToken(string $token, User $user): bool
    {
        $key = sprintf(self::AUTH_TOKEN_KEY, $token);
        /** @phpstan-ignore-next-line */
        return $this->redisManager->set($key, $user->id, 'ex', (config('jwt.ttl') * 60));
    }

    /**
     * @param string $token
     *
     * @return bool
     */
    public function removeAuthToken(string $token): bool
    {
        $key = sprintf(self::AUTH_TOKEN_KEY, $token);
        return $this->redisManager->del($key);
    }

    /**
     * @param string $token
     *
     * @return bool
     */
    public function exist(string $token): bool
    {
        $key = sprintf(self::AUTH_TOKEN_KEY, $token);

        return $this->redisManager->exists($key);
    }
}
