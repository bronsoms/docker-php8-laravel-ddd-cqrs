<?php

namespace Shared\Infrastructure\Service\Time;

use Shared\Domain\Service\SystemClockInterface;

class SystemClock implements SystemClockInterface
{
    public function now(): \DateTimeImmutable
    {
        return new \DateTimeImmutable();
    }
}
