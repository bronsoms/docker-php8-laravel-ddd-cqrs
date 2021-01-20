<?php

namespace App\SDK\Infrastructure\Service\Time;

use App\SDK\Domain\Service\SystemClockInterface;

class SystemClock implements SystemClockInterface
{
    public function now(): \DateTimeImmutable
    {
        return new \DateTimeImmutable();
    }
}
