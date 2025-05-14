<?php

namespace Tests\SDK\Unit\Domain\Messaging\Event\User;

use Shared\Domain\Messaging\Command\User\CreateUser;
use Shared\Domain\Messaging\Event\User\UserCreated;
use Tests\SDK\Tools\Stub\User\Domain\FirstNameStub;
use Tests\SDK\Tools\Stub\User\Domain\LastNameStub;
use Tests\SDK\Tools\Stub\User\Domain\PasswordStub;
use Tests\SDK\Tools\Stub\User\Domain\UserIdStub;
use Tests\SDK\Tools\Stub\User\Domain\UsernameStub;
use Tests\TestCase;

class UserCreatedTest extends TestCase
{
    public function testItShouldCreateEvent()
    {
        $userId = UserIdStub::random();
        $firstName = FirstNameStub::random();
        $lastName = LastNameStub::random();
        $username = UsernameStub::random();
        $password = PasswordStub::random()->hashed();

        $userCreated = new UserCreated($userId, $firstName, $lastName, $username, $password);

        static::assertEquals($userId, $userCreated->aggregateId());
        static::assertEquals($firstName, $userCreated->firstName());
        static::assertEquals($lastName, $userCreated->lastName());
        static::assertEquals($username, $userCreated->username());
        static::assertEquals($password, $userCreated->hashedPassword());
        static::assertSame('user.created', $userCreated->name());
    }

    public function testFromArrayAndSerializeShouldBeTheSame()
    {
        $userId = UserIdStub::random();
        $firstName = FirstNameStub::random();
        $lastName = LastNameStub::random();
        $username = UsernameStub::random();
        $password = PasswordStub::random()->hashed();

        $expected = UserCreated::fromArray([
            'aggregate_id' => $userId,
            'first_name'   => $firstName,
            'last_name'    => $lastName,
            'username'     => $username,
            'password'     => $password
        ]);

        static::assertSame([
            'aggregate_id' => $userId->userId(),
            'first_name'   => $firstName->firstName(),
            'last_name'    => $lastName->lastName(),
            'username'     => $username->username(),
            'password'     => $password
        ], $expected->serialize());
    }
}
