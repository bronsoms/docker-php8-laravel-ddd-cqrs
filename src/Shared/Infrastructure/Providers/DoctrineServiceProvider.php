<?php

namespace Shared\Infrastructure\Providers;

use Shared\Infrastructure\Persistence\Doctrine\TypeHinting\DoctrineFirstName;
use Shared\Infrastructure\Persistence\Doctrine\TypeHinting\DoctrineLastName;
use Shared\Infrastructure\Persistence\Doctrine\TypeHinting\DoctrineUsername;
use Shared\Infrastructure\Persistence\Doctrine\TypeHinting\DoctrineUserId;
use Shared\Infrastructure\Persistence\Doctrine\DoctrineEventRepository;
use Illuminate\Contracts\Support\DeferrableProvider;
use Doctrine\Common\Proxy\AbstractProxyFactory;
use Illuminate\Support\ServiceProvider;
use Shared\Infrastructure\Model\Event;
use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use Doctrine\DBAL\Types\Type;

class DoctrineServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public const ENTITY_MANAGER = 'Doctrine_EntityManager';

    public function register(): void
    {
        $this->app->singleton(self::ENTITY_MANAGER, function () {
            return new EntityManager(
                $this->app['db']->getDoctrineConnection(),
                $this->doctrineConfiguration($this->app['config']->get('database.doctrine.cache.path')),
            );
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

        // https://github.com/doctrine/orm/issues/9432
        $config->setLazyGhostObjectEnabled(true);

        return $config;
    }

    public function boot(): void
    {
        $this->registerDoctrineTypes();
    }

    public function provides(): array
    {
        return [
            self::ENTITY_MANAGER,
        ];
    }

    private static function registerDoctrineTypes()
    {
        $types = [
            DoctrineUserId::class,
            DoctrineFirstName::class,
            DoctrineLastName::class,
            DoctrineUsername::class,
        ];

        foreach ($types as $type) {
            if (!Type::hasType($type::NAME)) {
                Type::addType($type::NAME, $type);
            }
        }
    }
}
