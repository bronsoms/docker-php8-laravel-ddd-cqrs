<?php

namespace Tests\SDK\Unit\Domain\Exception;

use App\SDK\Domain\Exception\InvalidParametersException;
use App\SDK\Domain\Exception\DomainException;
use App\SDK\Domain\Exception\ExceptionCodes;
use Tests\ExceptionTestBase;

class InvalidParametersExceptionTest extends ExceptionTestBase
{
    protected string $exceptionToTest = InvalidParametersException::class;
    protected ?string $extendsFrom = DomainException::class;
    protected int $exceptionCode = ExceptionCodes::PARAMS_INVALID;
    protected string $exceptionMessage = 'Parameters are not valid, got: params';
    protected array $arguments = ['params'];
}