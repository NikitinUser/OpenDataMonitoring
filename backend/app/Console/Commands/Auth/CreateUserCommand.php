<?php

namespace App\Console\Commands\Auth;

use App\Exceptions\UserRegistrationException;
use App\Services\UserService;
use Illuminate\Console\Command;

class CreateUserCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auth:create-user {email} {password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $userService = app()->make(UserService::class);

        try {
            $user = $userService->createUser(
                $this->argument('email'),
                $this->argument('password')
            );
        } catch (UserRegistrationException $e) {
            $this->error($e->getMessage());
            return 0;
        }

        $this->info('User created:');
        $this->info(' -       id : '.$user->id);
        $this->info(' -    email : '.$user->email);

        return 1;
    }
}
