<?php

namespace Tests;

use Shared\Infrastructure\Providers\DoctrineServiceProvider;
use Doctrine\DBAL\Schema\AbstractSchemaManager;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\ORM\EntityManagerInterface;

class DatabaseTestCase extends TestCase
{
    protected ?\PDO $pdo;
    private ?AbstractSchemaManager $schemaManager;
    private ?AbstractPlatform $databasePlatform;

    public const IGNORE_TABLES = [
        'migrations',
        'counters',
    ];

    protected function setUp(): void
    {
        parent::setUp();

        /** @var EntityManagerInterface $em */
        $em = $this->app->make(DoctrineServiceProvider::ENTITY_MANAGER);
        $connection = $em->getConnection();

        $this->schemaManager = $connection->getSchemaManager();
        $this->databasePlatform = $connection->getDatabasePlatform();
        $this->pdo = $connection->getWrappedConnection();

    }

    private function allUsedTablesInDatabase(): array
    {
        $allTables = $this->schemaManager->listTableNames();
        $allowedTables = array_diff($allTables, self::IGNORE_TABLES);
        $usedTables = [];

        foreach ($allowedTables as $tableName) {
            $tableDetails = $this->schemaManager->listTableDetails($tableName);

            if (!$tableDetails->hasOption('autoincrement')
                || $tableDetails->getOption('autoincrement') > 0) {
                $usedTables[] = $tableName;
            }
        }

        return $usedTables;
    }

    private function truncateTables(array $tables): void
    {
        $this->pdo->query('SET FOREIGN_KEY_CHECKS=0');

        foreach ($tables as $table) {
            $query = $this->databasePlatform->getTruncateTableSQL($table);
            $this->pdo->query($query);
        }

        $this->pdo->query('SET FOREIGN_KEY_CHECKS=1');
    }

    public function tearDown(): void
    {
        $this->truncateTables($this->allUsedTablesInDatabase());

        $this->pdo = null;
        $this->schemaManager = null;
        $this->databasePlatform = null;
    }
}
