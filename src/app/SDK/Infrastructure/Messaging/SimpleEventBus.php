<?php

namespace App\SDK\Infrastructure\Messaging;

use App\SDK\Application\Exception\MethodNotImplementedException;
use App\SDK\Application\Messaging\Invoice\InvoiceHistoryListener;
use App\SDK\Infrastructure\Messaging\AMQP\EventDispatcher;
use App\SDK\Infrastructure\Messaging\Broadway\EventStoreEventListener;
use Broadway\Domain\DomainEventStream;
use Broadway\Domain\DomainMessage;
use Broadway\Domain\Metadata;
use Broadway\EventHandling\EventBus;
use Broadway\EventHandling\EventListener;
use Broadway\EventSourcing\MetadataEnrichment\MetadataEnricher;
use Broadway\EventStore\EventStore;
use Illuminate\Auth\AuthManager;
use Illuminate\Contracts\Foundation\Application;

class SimpleEventBus implements EventBus
{
    private bool $isPublishing = false;
    private array $queue = [];
    private Application $application;
    private MetadataEnricher $metadataEnricher;

    /** @var EventListener[]|null */
    private ?array $eventListeners;

    public function __construct(Application $application, MetadataEnricher $metadataEnricher)
    {
        $this->application = $application;
        $this->metadataEnricher = $metadataEnricher;
        $this->eventListeners = null;
    }

    /**
     * @throws MethodNotImplementedException
     */
    public function subscribe(EventListener $eventListener): void
    {
        throw new MethodNotImplementedException('subscribe', __CLASS__);
    }

    /**
     * {@inheritDoc}
     */
    public function publish(DomainEventStream $domainMessages): void
    {
        /** @var DomainMessage $domainMessage */
        foreach ($domainMessages as $domainMessage) {
            $this->queue[] = $domainMessage->andMetadata(
                $this->metadataEnricher->enrich($domainMessage->getMetadata())
            );
        }

        if (! $this->isPublishing) {
            $this->isPublishing = true;

            try {
                while ($domainMessage = array_shift($this->queue)) {
                    foreach ($this->eventListeners() as $eventListener) {
                        $eventListener->handle($domainMessage);
                    }
                }
            } finally {
                $this->isPublishing = false;
            }
        }
    }

    /** @return EventListener[] */
    private function eventListeners(): array
    {
        if (null !== $this->eventListeners) {
            return $this->eventListeners;
        }

        $this->eventListeners[] = $this->application->make(EventStoreEventListener::class);

        return $this->eventListeners;
    }
}
