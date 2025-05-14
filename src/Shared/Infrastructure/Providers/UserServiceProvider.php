<?php

namespace Shared\Infrastructure\Providers;

use Shared\Infrastructure\Persistence\User\DoctrineUserIdGenerator;
use Shared\Infrastructure\Persistence\User\DoctrineUserRepository;
use Broadway\EventHandling\EventBus;
use Illuminate\Contracts\Support\DeferrableProvider;
use Shared\Domain\Service\User\UserIdGenerator;
use Shared\Domain\Model\User\UserRepository;
use Illuminate\Support\ServiceProvider;
use Shared\Domain\Model\User\User;

class UserServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public function register()
    {
        $this->registerRepositories();
    }

    private function registerRepositories(): void
    {
        $this->app->bind(
            UserRepository::class,
            function () {
                $entityManager = $this->app->make(DoctrineServiceProvider::ENTITY_MANAGER);

                return new DoctrineUserRepository(
                    $this->app->make(EventBus::class),
                    $entityManager,
                    $entityManager->getClassMetadata(User::class),
                );
            }
        );

        $this->app->bind(UserIdGenerator::class, function () {
            $entityManager = $this->app->make(DoctrineServiceProvider::ENTITY_MANAGER);
            return new DoctrineUserIdGenerator($entityManager);
        });
    }

    public function provides()
    {
        return [
            UserRepository::class,
            UserIdGenerator::class,
        ];
    }
}
