<?php

namespace Tests\SDK\Unit\Domain\Exception;

use Shared\Domain\Exception\InvalidParametersException;
use Shared\Domain\Exception\DomainException;
use Shared\Domain\Exception\ExceptionCodes;
use Tests\ExceptionTestBase;

class InvalidParametersExceptionTest extends ExceptionTestBase
{
    protected string $exceptionToTest = InvalidParametersException::class;
    protected ?string $extendsFrom = DomainException::class;
    protected int $exceptionCode = ExceptionCodes::PARAMS_INVALID;
    protected string $exceptionMessage = 'Parameters are not valid, got: params';
    protected array $arguments = ['params'];
}