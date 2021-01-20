<?php

namespace App\SDK\Infrastructure\Providers;

use App\SDK\Infrastructure\Persistence\User\DoctrineUserIdGenerator;
use App\SDK\Infrastructure\Persistence\User\DoctrineUserRepository;
use Broadway\EventHandling\EventBus;
use Illuminate\Contracts\Support\DeferrableProvider;
use App\SDK\Domain\Service\User\UserIdGenerator;
use App\SDK\Domain\Model\User\UserRepository;
use Illuminate\Support\ServiceProvider;
use App\SDK\Domain\Model\User\User;

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
