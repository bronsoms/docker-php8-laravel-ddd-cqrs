<?php

namespace Tests\SDK\Unit\Domain\Exception\User;

use Shared\Domain\Exception\User\FirstNameNotValidException;
use Shared\Domain\Exception\DomainException;
use Shared\Domain\Exception\ExceptionCodes;
use Tests\TestCase;

class FirstNameNotValidExceptionTest extends TestCase
{
    public function test_valid_exception()
    {
        try {
            throw new FirstNameNotValidException();
        } catch (FirstNameNotValidException $firstNameNotValidException) {
            static::assertInstanceOf(DomainException::class, $firstNameNotValidException);
            static::assertSame(
                ExceptionCodes::FIRST_NAME_NOT_VALID,
                $firstNameNotValidException->getCode()
            );
            static::assertSame(
                $firstNameNotValidException->getMessage(),
                sprintf('First name is not valid')
            );
        }
    }
}
