<?php

namespace Tests\SDK\Unit\Infrastructure\Exception;

use App\SDK\Infrastructure\Exception\QueryHandlerMethodNotFoundException;
use App\SDK\Infrastructure\Exception\InfrastructureException;
use Tests\ExceptionTestBase;

class QueryHandlerMethodNotFoundExceptionTest extends ExceptionTestBase
{
    protected string $exceptionToTest = QueryHandlerMethodNotFoundException::class;
    protected ?string $extendsFrom = InfrastructureException::class;
    protected int $exceptionCode = 2001;
    protected string $exceptionMessage = 'Query handler method class_name->method_name() not found';
    protected array $arguments = ['class_name', 'method_name'];
}
