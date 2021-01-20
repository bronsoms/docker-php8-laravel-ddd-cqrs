<?php

namespace Tests\SDK\Unit\Infrastructure\Exception;

use App\SDK\Infrastructure\Exception\CommandHandlerNotFoundException;
use App\SDK\Infrastructure\Exception\InfrastructureException;
use Tests\ExceptionTestBase;

class CommandHandlerNotFoundExceptionTest extends ExceptionTestBase
{
    protected string $exceptionToTest = CommandHandlerNotFoundException::class;
    protected ?string $extendsFrom = InfrastructureException::class;
    protected int $exceptionCode = 2002;
    protected string $exceptionMessage = 'Command handler class_name not found';
    protected array $arguments = ['class_name'];
}
