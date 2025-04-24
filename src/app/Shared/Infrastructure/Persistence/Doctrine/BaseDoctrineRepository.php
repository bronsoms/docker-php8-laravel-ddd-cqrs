<?php

namespace Shared\Infrastructure\Persistence\Doctrine;

use Shared\Domain\Messaging\Event\Event;
use Shared\Domain\Service\EventSourcedAggregateRoot;
use Shared\Infrastructure\Exception\DataPersistenceException;
use Broadway\Domain\DomainMessage;
use Broadway\EventHandling\EventBus;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;
use Throwable;

abstract class BaseDoctrineRepository extends EntityRepository
{
    private EventBus $eventBus;
    private EntityManagerInterface $em;

    public function __construct(EventBus $eventBus, EntityManagerInterface $em, ClassMetadata $class)
    {
        parent::__construct($em, $class);

        $this->eventBus = $eventBus;
        $this->em = $em;
    }

    /**
     * @param EventSourcedAggregateRoot $entity
     *
     * @throws DataPersistenceException
     */
    public function saveAndEmitEvents($entity)
    {
        $domainStream = $entity->getUncommittedEvents();
        $connection = $this->em->getConnection();
        $connection->beginTransaction();

        try {
            $this->em->persist($entity);
            $this->em->flush();
            $this->eventBus->publish($domainStream);
            $connection->commit();
        } catch (Throwable $e) {
            $connection->rollBack();
            throw new DataPersistenceException($e->getMessage(), $e);
        }
    }
}
