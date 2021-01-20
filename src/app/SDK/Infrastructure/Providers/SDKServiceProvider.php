<?php

namespace App\SDK\Infrastructure\Providers;

use App\SDK\Infrastructure\Messaging\Broadway\Service\DomainMessageMetadataEnricher;
use App\SDK\Infrastructure\Messaging\SimpleCommandBus;
use App\SDK\Infrastructure\Messaging\SimpleEventBus;
use App\SDK\Infrastructure\Persistence\Doctrine\DoctrineEventRepository;
use Broadway\EventHandling\EventBus;
use Broadway\EventSourcing\MetadataEnrichment\MetadataEnricher;
use Broadway\EventStore\EventStore;
use Illuminate\Contracts\Support\DeferrableProvider;
use App\SDK\Infrastructure\Messaging\SimpleQueryBus;
use App\SDK\Infrastructure\Service\Time\SystemClock;
use App\SDK\Domain\Service\SystemClockInterface;
use App\SDK\Infrastructure\Messaging\QueryBus;
use Broadway\CommandHandling\CommandBus;
use Illuminate\Support\ServiceProvider;

class SDKServiceProvider extends ServiceProvider implements DeferrableProvider
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