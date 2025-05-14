<?php

namespace Shared\Domain\Model;

use Broadway\Domain\DomainEventStream;

interface AggregateRoot
{
    public function getUncommittedEvents(): DomainEventStream;

    /**
     * @return mixed
     */
    public function getAggregateRootId();
}
