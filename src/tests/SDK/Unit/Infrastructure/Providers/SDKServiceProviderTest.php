<?php

namespace Tests\SDK\Unit\Infrastructure\Providers;

use App\SDK\Infrastructure\Messaging\Broadway\Service\DomainMessageMetadataEnricher;
use App\SDK\Infrastructure\Persistence\Doctrine\DoctrineEventRepository;
use Broadway\EventSourcing\MetadataEnrichment\MetadataEnricher;
use App\SDK\Infrastructure\Providers\SDKServiceProvider;
use App\SDK\Infrastructure\Messaging\SimpleCommandBus;
use App\SDK\Infrastructure\Messaging\SimpleEventBus;
use App\SDK\Infrastructure\Messaging\SimpleQueryBus;
use App\SDK\Infrastructure\Service\Time\SystemClock;
use Illuminate\Contracts\Foundation\Application;
use App\SDK\Domain\Service\SystemClockInterface;
use App\SDK\Infrastructure\Messaging\QueryBus;
use Broadway\CommandHandling\CommandBus;
use Broadway\EventHandling\EventBus;
use Broadway\EventStore\EventStore;
use Tests\ServiceProviderTestCase;
use Prophecy\Prophet;

class SDKServiceProviderTest extends ServiceProviderTestCase
{
    /** @var Application */
    private $application;

    private SDKServiceProvider $sut;

    protected function setUp(): void
    {
        $this->application = (new Prophet())->prophesize(Application::class);
        $this->sut = new SDKServiceProvider($this->application->reveal());
    }

    public function testRegisterShouldBeValid()
    {
        $this->mockDirectAppBind($this->application, QueryBus::class, SimpleQueryBus::class);
        $this->mockDirectAppBind($this->application, CommandBus::class, SimpleCommandBus::class);

        $this->mockAppSingleton($this->application,
            EventBus::class,
            function () {
                return $this->registerMake($this->application, SimpleEventBus::class);
            }
        );

        $this->mockAppBind($this->application,
            SystemClockInterface::class,
            function () {
                return $this->registerMake($this->application, SystemClock::class);
            }
        );

        $this->mockDirectAppBind($this->application, MetadataEnricher::class, DomainMessageMetadataEnricher::class);
        $this->mockDirectAppBind($this->application, EventStore::class, DoctrineEventRepository::class);

        $this->sut->register();
    }

    public function test_provides_should_be_valid()
    {
        $expected = [
            SystemClockInterface::class,
            EventBus::class,
            QueryBus::class,
            CommandBus::class,
            EventBus::class,
            MetadataEnricher::class,
            EventStore::class,
        ];

        static::assertEquals($expected, $this->sut->provides());
    }
}
