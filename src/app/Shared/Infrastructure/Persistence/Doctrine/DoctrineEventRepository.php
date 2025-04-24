<?php

namespace Shared\Infrastructure\Persistence\Doctrine;

use Shared\Application\Exception\MethodNotImplementedException;
use Shared\Infrastructure\Exception\DataPersistenceException;
use Shared\Infrastructure\Model\Event;
use Broadway\Domain\DomainEventStream;
use Broadway\EventStore\EventStore;
use Broadway\Domain\DomainMessage;
use Doctrine\ORM\EntityRepository;
use Throwable;

class DoctrineEventRepository extends EntityRepository implements EventStore
{
    public function load($id): DomainEventStream
    {
        throw new MethodNotImplementedException('load', __CLASS__);
    }

    public function loadFromPlayhead($id, int $playhead): DomainEventStream
    {
        throw new MethodNotImplementedException('loadFromPlayhead', __CLASS__);
    }

    public function append($id, DomainEventStream $eventStream): void
    {
        $em = $this->getEntityManager();

        try {
            /** @var DomainMessage $domainMessage */
            foreach ($eventStream as $domainMessage) {
                /** @var \Shared\Domain\Messaging\Event\Event $payload */
                $payload = $domainMessage->getPayload();

                $em->persist(Event::create(
                    (string) $payload->aggregateId(),
                    $domainMessage->getPlayhead(),
                    $domainMessage->getMetadata()->serialize(),
                    $payload->serialize(),
                    $domainMessage->getRecordedOn()->toString(),
                    $payload->name()
                ));
            }

            $em->flush();
        } catch (Throwable $e) {
            throw new DataPersistenceException($e->getMessage(), $e);
        }
    }
}
