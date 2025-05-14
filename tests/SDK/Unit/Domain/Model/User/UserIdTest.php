<?php

namespace Tests\SDK\Unit\Domain\Model\User;

use Shared\Domain\Exception\User\UserIdNotValidException;
use Tests\SDK\Tools\Stub\User\Domain\UserIdStub;
use Tests\SDK\Tools\RandomNumberGenerator;
use Shared\Domain\Model\User\UserId;
use Tests\TestCase;

class UserIdTest extends TestCase
{
    public function testItShouldCreateUserId()
    {
        $id = RandomNumberGenerator::integer();
        $userId = UserId::fromString($id);

        static::assertEquals($id, $userId->userId());
        static::assertEquals($id, $userId->__toString());
    }

    public function testItShouldBeTrueWhenEqual()
    {
        $id = RandomNumberGenerator::integer();
        $userId = UserId::fromString($id);

        static::assertTrue(UserId::fromString($id)->equals($userId));
    }

    public function testItShouldBeFalseWhenDifferent()
    {
        $id = RandomNumberGenerator::integer();
        $userId = UserId::fromString($id);

        static::assertFalse(UserIdStub::random()->equals($userId));
    }

    public function testItShouldThrowAnExceptionWhenValueIsNotNumeric()
    {
        $id = $this->faker()->word;

        $this->expectException(UserIdNotValidException::class);
        UserId::fromString($id);
    }

    public function testItShouldThrowAnExceptionWhenValueIsLowerOrEqualThanZero()
    {
        $this->expectException(UserIdNotValidException::class);
        UserId::fromString(-5);

        $this->expectException(UserIdNotValidException::class);
        UserId::fromString(0);
    }
}
