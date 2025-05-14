<?php

namespace Tests\SDK\Unit\Domain\Exception\User;

use Shared\Domain\Exception\User\UsernameNotValidException;
use Shared\Domain\Exception\DomainException;
use Shared\Domain\Exception\ExceptionCodes;
use Tests\ExceptionTestBase;

class UsernameNotValidExceptionTest extends ExceptionTestBase
{
    protected string $exceptionToTest = UsernameNotValidException::class;
    protected ?string $extendsFrom = DomainException::class;
    protected int $exceptionCode = ExceptionCodes::USERNAME_NOT_VALID;
    protected string $exceptionMessage = 'Username is not valid. Reason: reason';
    protected array $arguments = ['reason'];
}