<?php

namespace App\SDK\Domain\Model\User;

use App\SDK\Domain\Messaging\Command\User\CreateUser;
use App\SDK\Domain\Service\SystemClockInterface;
use App\SDK\Domain\Service\User\UserIdGenerator;

class CreateUserFactory
{
    private SystemClockInterface $systemClock;
    private UserIdGenerator $userIdGenerator;

    public function __construct(SystemClockInterface $systemClock, UserIdGenerator $userIdGenerator)
    {
        $this->systemClock = $systemClock;
        $this->userIdGenerator = $userIdGenerator;
    }

    public function create(CreateUser $createUser): User
    {
        return User::createUser(
            $this->userIdGenerator->next(),
            $createUser->firstName(),
            $createUser->lastName(),
            $createUser->username(),
            $createUser->password()
            //$this->systemClock->now()
        );
    }
}
