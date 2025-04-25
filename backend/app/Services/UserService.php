<?php

namespace App\Services;

use App\Exceptions\UserRegistrationException;
use App\Models\User;

class UserService
{
    /**
     * @param string $email
     * @param string $password
     *
     * @return User
     * @throws UserRegistrationException
     */
    public function createUser(
        string $email,
        string $password
    ) {
        $email = strtolower($email);
        $login = strtolower($login ?? $email);
        $name = $name ?? $login;

        if ($this->emailAlreadyRegistered($email)) {
            throw new UserRegistrationException(
                trans('errors.user.email_already_registered', ['email' => $email])
            );
        }

        $user = new User();
        $user->password = $password;
        $user->email = $email;
        $user->name = $email;

        $user->save();

        return $user;
    }

    /**
     * @param string $email
     *
     * @return mixed
     */
    public function emailAlreadyRegistered(string $email)
    {
        return User::where('email', '=', $email)->exists();
    }

    /**
     * @param User $user
     * @param string $password
     *
     * @return void
     */
    public function changePassword(User $user, string $password): void
    {
        $user->password = $password;
        $user->save();
    }
}
