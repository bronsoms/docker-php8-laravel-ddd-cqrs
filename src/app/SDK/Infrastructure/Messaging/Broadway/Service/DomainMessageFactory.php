<?php

namespace App\SDK\Infrastructure\Messaging\Broadway\Service;

use Broadway\Domain\DomainMessage;
use Broadway\Domain\Metadata;

class DomainMessageFactory
{
    public static function build(string $id, int $playhead, Metadata $metadata, $payload): DomainMessage
    {
        return new DomainMessage(
            $id,
            $playhead,
            $metadata,
            $payload,
            DateTimeFactory::now()
        );
    }
}
