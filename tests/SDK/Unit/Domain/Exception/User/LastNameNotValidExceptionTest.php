<?php

namespace Tests\SDK\Unit\Domain\Exception\User;

use Shared\Domain\Exception\User\LastNameNotValidException;
use Shared\Domain\Exception\DomainException;
use Shared\Domain\Exception\ExceptionCodes;
use Tests\TestCase;

class LastNameNotValidExceptionTest extends TestCase
{
    public function test_valid_exception()
    {
        try {
            throw new LastNameNotValidException();
        } catch (LastNameNotValidException $lastNameNotValidException) {
            static::assertInstanceOf(DomainException::class, $lastNameNotValidException);
            static::assertSame(
                ExceptionCodes::LAST_NAME_NOT_VALID,
                $lastNameNotValidException->getCode()
            );
            static::assertSame(
                $lastNameNotValidException->getMessage(),
                sprintf('Last name is not valid')
            );
        }
    }
}
