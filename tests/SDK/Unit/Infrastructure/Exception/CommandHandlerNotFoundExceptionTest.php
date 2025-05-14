<?php

namespace Tests\SDK\Unit\Infrastructure\Exception;

use Shared\Infrastructure\Exception\CommandHandlerNotFoundException;
use Shared\Infrastructure\Exception\InfrastructureException;
use Tests\ExceptionTestBase;

class CommandHandlerNotFoundExceptionTest extends ExceptionTestBase
{
    protected string $exceptionToTest = CommandHandlerNotFoundException::class;
    protected ?string $extendsFrom = InfrastructureException::class;
    protected int $exceptionCode = 2002;
    protected string $exceptionMessage = 'Command handler class_name not found';
    protected array $arguments = ['class_name'];
}
