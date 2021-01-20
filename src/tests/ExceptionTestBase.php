<?php

namespace Tests;

use Exception;

class ExceptionTestBase extends TestCase
{
    protected string $exceptionToTest = Exception::class;
    protected ?string $extendsFrom;
    protected array $arguments = [];
    protected int $exceptionCode;
    protected string $exceptionMessage;

    public function testValidException(): void
    {
        try {
            throw new $this->exceptionToTest(...$this->arguments());
        } catch (Exception $e) {
            if (null !== $this->extendsFrom) {
                self::assertInstanceOf($this->extendsFrom, $e);
            }

            self::assertInstanceOf($this->exceptionToTest, $e);
            self::assertSame($this->exceptionCode, $e->getCode(), 'Invalid exception code found');
            self::assertSame($this->exceptionMessage, $e->getMessage(), 'Invalid exception message found');
        }
    }

    protected function arguments(): array
    {
        return $this->arguments;
    }
}
