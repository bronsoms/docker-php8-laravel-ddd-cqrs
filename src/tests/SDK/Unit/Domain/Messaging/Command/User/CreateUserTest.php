<?php

namespace Tests\SDK\Unit\Domain\Messaging\Command\User;

use App\SDK\Domain\Exception\InvalidParametersException;
use App\SDK\Domain\Messaging\Command\User\CreateUser;
use Tests\SDK\Tools\Stub\User\Domain\FirstNameStub;
use Tests\SDK\Tools\Stub\User\Domain\LastNameStub;
use Tests\SDK\Tools\Stub\User\Domain\PasswordStub;
use Tests\SDK\Tools\Stub\User\Domain\UsernameStub;
use Tests\TestCase;

class CreateUserTest extends TestCase
{
    public function testItShouldCreateCommand()
    {
        $firstName = FirstNameStub::random();
        $lastName = LastNameStub::random();
        $username = UsernameStub::random();
        $password = PasswordStub::random();

        $createUser = new CreateUser($firstName, $lastName, $username, $password);

        static::assertEquals($firstName, $createUser->firstName());
        static::assertEquals($lastName, $createUser->lastName());
        static::assertEquals($username, $createUser->username());
        static::assertEquals($password, $createUser->password());
    }

    public function testFromArrayAndSerializeShouldBeTheSame()
    {
        $firstName = FirstNameStub::random();
        $lastName = LastNameStub::random();
        $username = UsernameStub::random();
        $password = PasswordStub::random();

        $expected = CreateUser::fromArray([
            'first_name' => $firstName,
            'last_name' => $lastName,
            'username' => $username,
            'password' => $password,
        ]);

        static::assertSame([
            'first_name' => $firstName->firstName(),
            'last_name' => $lastName->lastName(),
            'username' => $username->username(),
            'password' => $password->password(),
        ], $expected->serialize());
    }

    public function test_fromArray_invalid_constructor_throw_exception()
    {
        static::expectException(InvalidParametersException::class);
        CreateUser::fromArray([]);
    }
}
