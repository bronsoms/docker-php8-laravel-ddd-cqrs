<?php

namespace App\SDK\Domain\Service;

interface SystemClockInterface
{
    public function now(): \DateTimeImmutable;
}
