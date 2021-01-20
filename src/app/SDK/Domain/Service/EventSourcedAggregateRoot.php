<?php

namespace App\SDK\Domain\Service;

use App\SDK\Infrastructure\Messaging\Broadway\Service\DomainMessageFactory;
use App\SDK\Domain\Messaging\Event\Event;
use Broadway\Domain\DomainEventStream;
use Broadway\Domain\DomainMessage;
use Broadway\Domain\Metadata;

trait EventSourcedAggregateRoot
{
    /** @var DomainMessage[] */
    private $uncommittedEvents = [];

    /** @var int */
    private $playhead = -1; // 0-based playhead allows events[0] to contain playhead 0

    public function getUncommittedEvents(): DomainEventStream
    {
        $stream = new DomainEventStream($this->uncommittedEvents);
        $this->uncommittedEvents = [];

        return $stream;
    }

    public function addEvent(Event $event): void
    {
        $this->playhead++;

        $aggregateId = method_exists($this, 'getAggregateRootId')
            ? $this->getAggregateRootId()
            : $event->aggregateId();

        $this->uncommittedEvents[] = DomainMessageFactory::build(
            $aggregateId,
            $this->playhead,
            new Metadata([]),
            $event
        );
    }
}
