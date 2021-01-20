<?php

namespace App\SDK\Infrastructure\Providers;

use App\SDK\Infrastructure\Model\Event;
use App\SDK\Infrastructure\Persistence\Doctrine\DoctrineEventRepository;
use App\SDK\Infrastructure\Persistence\Doctrine\TypeHinting\DoctrineCustomTypeRegisterer;
use Broadway\Domain\DomainMessage;
use Illuminate\Contracts\Support\DeferrableProvider;
use Doctrine\Common\Proxy\AbstractProxyFactory;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;
use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;

class DoctrineServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public const ENTITY_MANAGER = 'Doctrine_EntityManager';

    public function register(): void
    {
        $this->app->singleton(self::ENTITY_MANAGER, function () {
            $configDBConnection = Config::get('database.connections.mysql');
            $cacheDir = Config::get('database.doctrine.cache.path');

            $dbConnection = [
                'dbname' => $configDBConnection['database'],
                'user' => $configDBConnection['username'],
                'password' => $configDBConnection['password'],
                'host' => $configDBConnection['host'],
                'port' => $configDBConnection['port'],
                'driver' => 'pdo_mysql',
            ];

            return EntityManager::create($dbConnection, $this->doctrineConfiguration($cacheDir));
        });

        $this->app->bind(
            DoctrineEventRepository::class,
            function () {
                $entityManager = $this->app->make(DoctrineServiceProvider::ENTITY_MANAGER);

                return new DoctrineEventRepository(
                    $entityManager,
                    $entityManager->getClassMetadata(Event::class),
                );
            }
        );
    }

    private function doctrineConfiguration(string $cacheDir): Configuration
    {
        $config = Setup::createYAMLMetadataConfiguration([__DIR__ . '/../Persistence/Doctrine/Mapping']);
        $config->setAutoGenerateProxyClasses(AbstractProxyFactory::AUTOGENERATE_FILE_NOT_EXISTS);

        $config->setProxyDir($cacheDir . '/Proxy');
        $config->setProxyNamespace('Infrastructure\Persistence\Doctrine\Proxies');

        return $config;
    }

    public function boot(): void
    {
        DoctrineCustomTypeRegisterer::registerTypes();
    }

    public function provides(): array
    {
        return [
            self::ENTITY_MANAGER,
        ];
    }
}
