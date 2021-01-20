<?php

namespace Tests\SDK\Unit\Domain\Model\User;

use Tests\SDK\Tools\Stub\User\Domain\FirstNameStub;
use Tests\SDK\Tools\Stub\User\Domain\LastNameStub;
use Tests\SDK\Tools\Stub\User\Domain\UsernameStub;
use Tests\SDK\Tools\Stub\User\Domain\PasswordStub;
use Tests\SDK\Tools\Stub\User\Domain\UserIdStub;
use App\SDK\Domain\Model\User\User;
use Tests\TestCase;

class UserTest extends TestCase
{
    public function testUserShouldBeCreated()
    {
        $userId = UserIdStub::random();
        $firstName = FirstNameStub::random();
        $lastName = LastNameStub::random();
        $username = UsernameStub::random();
        $password = PasswordStub::random();

        $user = User::createUser($userId, $firstName, $lastName, $username, $password);

        static::assertEquals($user->userId(), $userId);
        static::assertEquals($user->getAggregateRootId(), $userId);
        static::assertEquals($user->firstName(), $firstName);
        static::assertEquals($user->lastName(), $lastName);
        static::assertEquals($user->username(), $username);
        static::assertEquals($user->getJWTIdentifier(), $userId->userId());
        static::assertEquals($user->getJWTCustomClaims(), []);
        static::assertTrue(password_verify($password->password(), $user->password()));
        static::assertTrue(password_verify($password->password(), $user->getAuthPassword()));
    }
}
