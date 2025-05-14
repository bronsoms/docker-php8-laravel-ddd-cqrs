<?php

namespace Tests\SDK\Unit\Application\Exception;

use Shared\Application\Exception\MethodNotImplementedException;
use Shared\Application\Exception\ApplicationException;
use Shared\Application\Exception\ExceptionCodes;
use Tests\TestCase;

class MethodNotImplementedExceptionTest extends TestCase
{
    public function test_valid_exception()
    {
        $method = $this->faker()->word;
        $class = $this->faker()->word;

        try {
            throw new MethodNotImplementedException($method, $class);
        } catch (MethodNotImplementedException $methodNotImplementedException) {
            static::assertInstanceOf(ApplicationException::class, $methodNotImplementedException);
            static::assertSame(
                ExceptionCodes::METHOD_NOT_IMPLEMENTED,
                $methodNotImplementedException->getCode()
            );
            static::assertSame(
                $methodNotImplementedException->getMessage(),
                sprintf('Method %s not implement for class %s', $method, $class)
            );
        }
    }
}