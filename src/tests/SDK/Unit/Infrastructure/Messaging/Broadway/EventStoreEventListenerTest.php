<?php

namespace Tests\SDK\Unit\Infrastructure\Messaging\Broadway;

use App\SDK\Infrastructure\Messaging\Broadway\Service\DomainMessageFactory;
use App\SDK\Infrastructure\Messaging\Broadway\EventStoreEventListener;
use Tests\SDK\Tools\RandomNumberGenerator;
use App\SDK\Domain\Messaging\Event\Event;
use Broadway\Domain\DomainEventStream;
use Broadway\EventStore\EventStore;
use Broadway\Domain\Metadata;
use Prophecy\Argument;
use Tests\TestCase;

class EventStoreEventListenerTest extends TestCase
{
    public function testEventListenerShouldHandleMessage()
    {
        $messageId = RandomNumberGenerator::integer();
        $eventStore = $this->prophesize(EventStore::class);
        $event = $this->prophesize(Event::class);

        $domainMessage = DomainMessageFactory::build($messageId, 0, new Metadata([Argument::any()]), $event->reveal());
        $sut = new EventStoreEventListener($eventStore->reveal());

        $eventStore->append($messageId, new DomainEventStream([$domainMessage]))
            ->shouldBeCalledOnce();

        $sut->handle($domainMessage);
    }
}
