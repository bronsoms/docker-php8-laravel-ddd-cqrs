<?php

namespace App\SDK\Infrastructure\Messaging;

use App\SDK\Domain\Messaging\Query\Query;
use App\SDK\Infrastructure\Exception\QueryHandlerClassNotFoundException;

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
