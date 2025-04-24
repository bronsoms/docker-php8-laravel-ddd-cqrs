<?php

namespace Shared\Infrastructure\Providers;

use Shared\Infrastructure\Messaging\Broadway\Service\DomainMessageMetadataEnricher;
use Shared\Infrastructure\Messaging\SimpleCommandBus;
use Shared\Infrastructure\Messaging\SimpleEventBus;
use Shared\Infrastructure\Persistence\Doctrine\DoctrineEventRepository;
use Broadway\EventHandling\EventBus;
use Broadway\EventSourcing\MetadataEnrichment\MetadataEnricher;
use Broadway\EventStore\EventStore;
use Illuminate\Contracts\Support\DeferrableProvider;
use Shared\Infrastructure\Messaging\SimpleQueryBus;
use Shared\Infrastructure\Service\Time\SystemClock;
use Shared\Domain\Service\SystemClockInterface;
use Shared\Infrastructure\Messaging\QueryBus;
use Broadway\CommandHandling\CommandBus;
use Illuminate\Support\ServiceProvider;

class SharedServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public function register() {
        $this->app->bind(QueryBus::class, SimpleQueryBus::class);
        $this->app->bind(CommandBus::class, SimpleCommandBus::class);

        $this->app->singleton(
            EventBus::class,
            function () {
                return $this->app->make(SimpleEventBus::class);
            }
        );

        $this->app->bind(
            SystemClockInterface::class,
            function () {
                return $this->app->make(SystemClock::class);
            }
        );

        $this->app->bind(MetadataEnricher::class, DomainMessageMetadataEnricher::class);
        $this->app->bind(EventStore::class, DoctrineEventRepository::class);
    }

    public function provides()
    {
        return [
            SystemClockInterface::class,
            EventBus::class,
            QueryBus::class,
            CommandBus::class,
            EventBus::class,
            MetadataEnricher::class,
            EventStore::class,
        ];
    }

}