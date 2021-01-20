<?php

namespace App\SDK\Infrastructure\Messaging;

use App\SDK\Infrastructure\Exception\QueryHandlerClassNotFoundException;
use Illuminate\Contracts\Container\Container;
use App\SDK\Domain\Messaging\Query\Query;

class SimpleQueryBus implements QueryBus
{
    /** @var Container */
    private $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * {@inheritDoc}
     */
    public function dispatch(Query $query)
    {
        $handlerClass = \get_class($query) . 'Handler';

        /** @var QueryHandler $handler */
        if ($handler = $this->container->make($handlerClass)) {
            return $handler->handle($query);
        }

        throw new QueryHandlerClassNotFoundException($handlerClass);
    }
}
