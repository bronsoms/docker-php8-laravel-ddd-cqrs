<?php

namespace Shared\Infrastructure\Messaging;

use Shared\Domain\Messaging\Query\Query;
use Shared\Infrastructure\Exception\QueryHandlerClassNotFoundException;

/**
 * Dispatches query objects to the subscribed query handlers.
 */
interface QueryBus
{
    /**
     * Dispatches the query $query to the proper QueryHandler
     *
     * @return mixed
     * @throws QueryHandlerClassNotFoundException
     */
    public function dispatch(Query $query);
}
