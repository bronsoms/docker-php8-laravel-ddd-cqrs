<?php

namespace Tests\SDK\Unit\Infrastructure\Exception;

use Shared\Infrastructure\Exception\QueryHandlerClassNotFoundException;
use Shared\Infrastructure\Exception\InfrastructureException;
use Tests\ExceptionTestBase;

class QueryHandlerClassNotFoundExceptionTest extends ExceptionTestBase
{
    protected string $exceptionToTest = QueryHandlerClassNotFoundException::class;
    protected ?string $extendsFrom = InfrastructureException::class;
    protected int $exceptionCode = 2000;
    protected string $exceptionMessage = 'Query handler class class_name not found';
    protected array $arguments = ['class_name'];
}
