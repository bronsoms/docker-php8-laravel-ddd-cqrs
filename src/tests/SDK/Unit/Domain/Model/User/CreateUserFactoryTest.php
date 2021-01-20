<?php

namespace Tests\SDK\Unit\Domain\Model\User;

use App\SDK\Domain\Messaging\Command\User\CreateUser;
use Tests\SDK\Tools\Stub\User\Domain\FirstNameStub;
use Tests\SDK\Tools\Stub\User\Domain\LastNameStub;
use Tests\SDK\Tools\Stub\User\Domain\PasswordStub;
use Tests\SDK\Tools\Stub\User\Domain\UsernameStub;
use Tests\SDK\Tools\Stub\User\Domain\UserIdStub;
use App\SDK\Domain\Service\SystemClockInterface;
use App\SDK\Domain\Model\User\CreateUserFactory;
use App\SDK\Domain\Service\User\UserIdGenerator;
use App\SDK\Domain\Model\User\User;
use Tests\TestCase;

class CreateUserFactoryTest extends TestCase
{
    public function testItShouldCreateUserInstance()
    {
        $userIdGenerator = $this->prophesize(UserIdGenerator::class);
        $systemClock = $this->prophesize(SystemClockInterface::class);
        $sut = new CreateUserFactory($systemClock->reveal(), $userIdGenerator->reveal());

        $userId = UserIdStub::random();
        $userIdGenerator->next()->shouldBeCalledOnce()->willReturn($userId);

        $firstName = FirstNameStub::random();
        $lastName = LastNameStub::random();
        $username = UsernameStub::random();
        $password = PasswordStub::random();

        $createUser = new CreateUser($firstName, $lastName, $username, $password);

        $user = $sut->create($createUser);

        static::assertInstanceOf(User::class, $user);
        static::assertEquals($userId, $user->userId());
        static::assertEquals($createUser->firstName(), $user->firstName());
        static::assertEquals($createUser->lastName(), $user->lastName());
        static::assertEquals($createUser->username(), $user->username());
        static::assertTrue(password_verify($password->password(), $user->password()));
    }
}
