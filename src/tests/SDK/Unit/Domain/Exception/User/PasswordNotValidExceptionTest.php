<?php

namespace Tests\SDK\Unit\Domain\Exception\User;

use App\SDK\Domain\Exception\User\PasswordNotValidException;
use App\SDK\Domain\Exception\DomainException;
use App\SDK\Domain\Exception\ExceptionCodes;
use Tests\ExceptionTestBase;

class PasswordNotValidExceptionTest extends ExceptionTestBase
{
    protected string $exceptionToTest = PasswordNotValidException::class;
    protected ?string $extendsFrom = DomainException::class;
    protected int $exceptionCode = ExceptionCodes::PASSWORD_NOT_VALID;
    protected string $exceptionMessage = 'reason';
    protected array $arguments = ['reason'];
}