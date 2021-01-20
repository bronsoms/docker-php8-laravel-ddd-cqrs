<?php

namespace Tests\SDK\Unit\Infrastructure\Messaging;

use App\SDK\Infrastructure\Exception\CommandHandlerNotFoundException;
use App\SDK\Application\Exception\MethodNotImplementedException;
use App\SDK\Infrastructure\Messaging\SimpleCommandBus;
use Illuminate\Contracts\Container\Container;
use App\SDK\Domain\Messaging\Command\Command;
use Broadway\CommandHandling\CommandHandler;
use Tests\TestCase;

class SimpleCommandBusTest extends TestCase
{
    /** @var Container */
    private $container;

    /** @var SimpleCommandBus */
    private $sut;

    public function setUp(): void
    {
        $this->container = $this->prophesize(Container::class);

        $this->sut = new SimpleCommandBus($this->container->reveal());
    }

    public function testItShouldThrowExceptionWhenSubscribeMethodIsInvoked()
    {
        $this->expectException(MethodNotImplementedException::class);

        $commandHandler = $this->prophesize(CommandHandler::class);

        $this->sut->subscribe($commandHandler->reveal());
    }

    public function testItShouldHandleTheCommand()
    {
        $command = $this->prophesize(Command::class);

        $handlerClass = \get_class($command) . SimpleCommandBus::HANDLER_SUFFIX;

        $commandHandler = $this->prophesize(CommandHandler::class);
        $commandHandler->handle($command)->shouldBeCalledTimes(1);

        $this->container->make($handlerClass)->shouldBeCalledTimes(1)->willReturn($commandHandler);

        $this->sut->dispatch($command);
    }

    public function testItShouldNotHandleTheCommandAndThrowException()
    {
        $this->expectException(CommandHandlerNotFoundException::class);

        $command = $this->prophesize(Command::class);

        $handlerClass = \get_class($command) . SimpleCommandBus::HANDLER_SUFFIX;

        $this->container->make($handlerClass)->shouldBeCalledTimes(1)->willReturn(null);

        $this->sut->dispatch($command);
    }
}
