<?php

namespace App\SDK\Infrastructure\Messaging\Broadway;

use Broadway\Domain\DomainEventStream;
use Broadway\Domain\DomainMessage;
use Broadway\EventHandling\EventListener;
use Broadway\EventStore\EventStore;

class EventStoreEventListener implements EventListener
{
    private EventStore $eventStore;

    public function __construct(EventStore $eventStore)
    {
        $this->eventStore = $eventStore;
    }

    public function handle(DomainMessage $domainMessage): void
    {
        $this->eventStore->append($domainMessage->getId(), new DomainEventStream([$domainMessage]));
    }
}