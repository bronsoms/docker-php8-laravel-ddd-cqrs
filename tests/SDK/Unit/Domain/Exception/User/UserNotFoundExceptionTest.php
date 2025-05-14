<?php

namespace Tests\SDK\Unit\Domain\Exception\User;

use Shared\Domain\Exception\User\UserNotFoundException;
use Shared\Domain\Exception\DomainException;
use Shared\Domain\Exception\ExceptionCodes;
use Tests\TestCase;

class UserNotFoundExceptionTest extends TestCase
{
    public function test_valid_exception()
    {
        try {
            throw new UserNotFoundException();
        } catch (UserNotFoundException $userNotFoundException) {
            static::assertInstanceOf(DomainException::class, $userNotFoundException);
            static::assertSame(
                ExceptionCodes::USER_NOT_FOUND,
                $userNotFoundException->getCode()
            );
            static::assertSame(
                'User not found',
                $userNotFoundException->getMessage()
            );
        }
    }
}
