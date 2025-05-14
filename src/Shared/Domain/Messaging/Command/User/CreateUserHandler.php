<?php

namespace Shared\Domain\Messaging\Command\User;

use Broadway\CommandHandling\SimpleCommandHandler;
use Shared\Domain\Model\User\CreateUserFactory;
use Shared\Domain\Model\User\UserRepository;

class CreateUserHandler extends SimpleCommandHandler
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly CreateUserFactory $userFactory
    ) {
    }

    public function handleCreateUser(CreateUser $command): void
    {
        $user = $this->userFactory->create($command);

        $this->userRepository->saveAndEmitEvents($user);
    }
}
