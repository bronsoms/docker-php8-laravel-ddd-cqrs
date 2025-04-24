<?php

namespace Tests\SDK\Unit\Infrastructure\Exception;

use Shared\Infrastructure\Exception\DataPersistenceException;
use Shared\Infrastructure\Exception\InfrastructureException;
use Tests\ExceptionTestBase;

class DataPersistenceExceptionTest extends ExceptionTestBase
{
    protected string $exceptionToTest = DataPersistenceException::class;
    protected ?string $extendsFrom = InfrastructureException::class;
    protected int $exceptionCode = 1000;
    protected string $exceptionMessage = 'There was a persistence problem: reason';
    protected array $arguments = ['reason'];
}
