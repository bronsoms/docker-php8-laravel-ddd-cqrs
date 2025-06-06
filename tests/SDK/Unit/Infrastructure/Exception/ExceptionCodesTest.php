<?php

namespace Tests\SDK\Unit\Infrastructure\Exception;

use Shared\Infrastructure\Exception\ExceptionCodes;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

class ExceptionCodesTest extends TestCase
{
    public function testShouldNotHaveAnyValueRepeated(): void
    {
        $codes = (new ReflectionClass(ExceptionCodes::class))->getConstants();

        foreach (array_count_values($codes) as $code => $count) {
            static::assertSame(1, $count, sprintf('Duplication for code: %s', $code));
        }
    }
}
