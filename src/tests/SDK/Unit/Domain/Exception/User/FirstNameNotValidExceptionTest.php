<?php

namespace Tests\SDK\Unit\Domain\Exception\User;

use App\SDK\Domain\Exception\User\FirstNameNotValidException;
use App\SDK\Domain\Exception\DomainException;
use App\SDK\Domain\Exception\ExceptionCodes;
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
