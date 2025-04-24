<?php

namespace Shared\Domain\Service;

interface SystemClockInterface
{
    public function now(): \DateTimeImmutable;
}
