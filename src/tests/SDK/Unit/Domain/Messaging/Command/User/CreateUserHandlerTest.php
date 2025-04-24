<?php

namespace Tests\SDK\Unit\Domain\Messaging\Command\User;

use Shared\Domain\Messaging\Command\User\CreateUser;
use Shared\Domain\Messaging\Command\User\CreateUserHandler;
use Shared\Domain\Model\User\CreateUserFactory;
use Shared\Domain\Model\User\UserRepository;
use Tests\SDK\Tools\Stub\User\Domain\FirstNameStub;
use Tests\SDK\Tools\Stub\User\Domain\LastNameStub;
use Tests\SDK\Tools\Stub\User\Domain\PasswordStub;
use Tests\SDK\Tools\Stub\User\Domain\UsernameStub;
use Tests\SDK\Tools\Stub\User\Domain\UserStub;
use Tests\TestCase;

class CreateUserHandlerTest extends TestCase
{
    public function testItShouldHandle()
    {
        $userRepository = $this->prophesize(UserRepository::class);
        $createUserFactory = $this->prophesize(CreateUserFactory::class);
        $sut = new CreateUserHandler($userRepository->reveal(), $createUserFactory->reveal());

        $firstName = FirstNameStub::random();
        $lastName = LastNameStub::random();
        $username = UsernameStub::random();
        $password = PasswordStub::random();

        $user = UserStub::create([
            'first_name' => $firstName,
            'last_name'  => $lastName,
            'username'   => $username,
            'password'   => $password,
        ]);

        $createUser = new CreateUser($firstName, $lastName, $username, $password);

        $createUserFactory->create($createUser)
            ->shouldBeCalledOnce()
            ->willReturn($user);

        $userRepository->saveAndEmitEvents($user)->shouldBeCalledOnce();

        $sut->handleCreateUser($createUser);
    }
}
