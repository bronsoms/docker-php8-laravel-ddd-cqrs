<?php

namespace Shared\Infrastructure\Persistence\Doctrine;

use Shared\Infrastructure\Exception\DataPersistenceException;
use Shared\Application\Service\IdGenerator;
use Doctrine\ORM\EntityManagerInterface;
use Throwable;

abstract class DoctrineIdGenerator implements IdGenerator
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    abstract public function name(): string;

    public function next()
    {
        $connection = $this->em->getConnection();
        $connection->beginTransaction();

        try {
            $query = <<<SQL
                SELECT c.count
                FROM counters c
                WHERE c.name = :counterName
SQL;
            $counter = $connection->fetchOne($query, [
                ':counterName' => $this->name()
            ]);

            $countValue = ++$counter;

            $connection->update('counters', [
                'count' => $countValue
            ], [
                'name' => $this->name()
            ]);

            $connection->commit();

            return $countValue;

        } catch (Throwable $e) {
            $connection->rollBack();
            throw new DataPersistenceException($e->getMessage(), $e);
        }
    }

}
