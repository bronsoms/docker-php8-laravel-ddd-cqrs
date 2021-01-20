<?php

namespace Tests\SDK\Unit\Infrastructure\Model;

use Tests\SDK\Tools\RandomNumberGenerator;
use App\SDK\Infrastructure\Model\Event;
use Tests\TestCase;

class EventTest extends TestCase
{
    public function testEventShouldBeCreated()
    {
        $uuid = $this->faker()->uuid;
        $playhead = RandomNumberGenerator::integer();
        $metadata = [RandomNumberGenerator::integer()];
        $payload = [RandomNumberGenerator::integer()];
        $recordedOn = $this->faker()->date();
        $type = $this->faker()->word;

        $event = new Event(
            $uuid,
            $playhead,
            $metadata,
            $payload,
            $recordedOn,
            $type
        );

        static::assertSame($uuid, $event->uuid());
        static::assertSame($playhead, $event->playhead());
        static::assertSame($metadata, $event->metadata());
        static::assertSame($payload, $event->payload());
        static::assertSame($recordedOn, $event->recordedOn());
        static::assertSame($type, $event->type());
    }
}
