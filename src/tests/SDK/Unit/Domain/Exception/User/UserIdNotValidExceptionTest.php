<?php

namespace Tests\SDK\Unit\Domain\Exception\User;

use App\SDK\Domain\Exception\User\UserIdNotValidException;
use App\SDK\Domain\Exception\DomainException;
use App\SDK\Domain\Exception\ExceptionCodes;
use Tests\SDK\Tools\RandomNumberGenerator;
use Tests\TestCase;

class UserIdNotValidExceptionTest extends TestCase
{
    public function test_valid_exception()
    {
        $userId = RandomNumberGenerator::integer();
        
        try {
            throw new UserIdNotValidException($userId);
        } catch (UserIdNotValidException $userIdNotValidException) {
            static::assertInstanceOf(DomainException::class, $userIdNotValidException);
            static::assertSame(
                ExceptionCodes::USER_ID_NOT_VALID,
                $userIdNotValidException->getCode()
            );
            static::assertSame(
                sprintf('Invalid user identifier %s ', $userId),
                $userIdNotValidException->getMessage()
            );
        }
    }
}
