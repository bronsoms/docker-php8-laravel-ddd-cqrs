<?php

namespace Tests\SDK\Unit\Infrastructure\Messaging;

use Broadway\EventSourcing\MetadataEnrichment\MetadataEnricher;
use App\SDK\Application\Exception\MethodNotImplementedException;
use App\SDK\Infrastructure\Messaging\SimpleEventBus;
use Illuminate\Contracts\Foundation\Application;
use Broadway\EventHandling\EventListener;
use Tests\TestCase;

class SimpleEventBusTest extends TestCase
{
    /** @var Application */
    private $application;

    /** @var MetadataEnricher */
    private $metadataEnricher;

    /** @var SimpleEventBus */
    private $sut;

    public function setUp(): void
    {
        $this->application = $this->prophesize(Application::class);
        $this->metadataEnricher = $this->prophesize(MetadataEnricher::class);
        $this->sut = new SimpleEventBus(
            $this->application->reveal(),
            $this->metadataEnricher->reveal()
        );
    }

    public function testItShouldThrowExceptionWhenSubscribeMethodIsInvoked()
    {
        $this->expectException(MethodNotImplementedException::class);

        /** @var EventListener $eventListener */
        $eventListener = $this->prophesize(EventListener::class);

        $this->sut->subscribe($eventListener->reveal());
    }
}

