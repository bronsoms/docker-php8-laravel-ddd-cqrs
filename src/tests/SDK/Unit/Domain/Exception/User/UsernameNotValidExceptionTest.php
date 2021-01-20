<?php

namespace Tests\SDK\Unit\Domain\Exception\User;

use App\SDK\Domain\Exception\User\UsernameNotValidException;
use App\SDK\Domain\Exception\DomainException;
use App\SDK\Domain\Exception\ExceptionCodes;
use Tests\ExceptionTestBase;

class UsernameNotValidExceptionTest extends ExceptionTestBase
{
    protected string $exceptionToTest = UsernameNotValidException::class;
    protected ?string $extendsFrom = DomainException::class;
    protected int $exceptionCode = ExceptionCodes::USERNAME_NOT_VALID;
    protected string $exceptionMessage = 'Username is not valid. Reason: reason';
    protected array $arguments = ['reason'];
}