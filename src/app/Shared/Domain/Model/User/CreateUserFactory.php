<?php

namespace Shared\Domain\Model\User;

use Shared\Domain\Messaging\Command\User\CreateUser;
use Shared\Domain\Service\SystemClockInterface;
use Shared\Domain\Service\User\UserIdGenerator;

class CreateUserFactory
{
    public function __construct(
        private readonly SystemClockInterface $systemClock,
        private readonly UserIdGenerator $userIdGenerator
    ) {
    }

    public function create(CreateUser $createUser): User
    {
        return User::createUser(
            $this->userIdGenerator->next(),
            $createUser->firstName,
            $createUser->lastName,
            $createUser->username,
            $createUser->password,
            $this->systemClock->now()
        );
    }
}
