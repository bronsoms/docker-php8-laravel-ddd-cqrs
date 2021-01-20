<?php

namespace App\SDK\Domain\Messaging\Command\User;

use Broadway\CommandHandling\SimpleCommandHandler;
use App\SDK\Domain\Model\User\CreateUserFactory;
use App\SDK\Domain\Model\User\UserRepository;

class CreateUserHandler extends SimpleCommandHandler
{
    private UserRepository $userRepository;
    private CreateUserFactory $userFactory;

    public function __construct(UserRepository $userRepository, CreateUserFactory $userFactory)
    {
        $this->userRepository = $userRepository;
        $this->userFactory = $userFactory;
    }

    public function handleCreateUser(CreateUser $command): void
    {
        $user = $this->userFactory->create($command);

        $this->userRepository->saveAndEmitEvents($user);
    }
}
