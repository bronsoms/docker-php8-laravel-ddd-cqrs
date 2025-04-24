<?php

namespace Shared\Infrastructure\Messaging;

use Shared\Infrastructure\Exception\CommandHandlerNotFoundException;
use Shared\Application\Exception\MethodNotImplementedException;
use Illuminate\Contracts\Container\Container;
use Broadway\CommandHandling\CommandHandler;
use Broadway\CommandHandling\CommandBus;

class SimpleCommandBus implements CommandBus
{
    public const HANDLER_SUFFIX = 'Handler';

    /** @var Container */
    private $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * @throws MethodNotImplementedException
     */
    public function subscribe(CommandHandler $handler): void
    {
        throw new MethodNotImplementedException('subscribe', __CLASS__);
    }

    /**
     * @throws CommandHandlerNotFoundException
     */
    public function dispatch($command): void
    {
        $this->handler($command)->handle($command);
    }

    /**
     * @throws CommandHandlerNotFoundException
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    protected function handler($command): CommandHandler
    {
        $handlerClass = \get_class($command) . self::HANDLER_SUFFIX;

        /** @var CommandHandler $handler */
        $handler = $this->container->make($handlerClass);

        if (!$handler) {
            throw new CommandHandlerNotFoundException($handlerClass);
        }

        return $handler;
    }
}
