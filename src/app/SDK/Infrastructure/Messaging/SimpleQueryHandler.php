<?php

namespace App\SDK\Infrastructure\Messaging;

use App\SDK\Domain\Messaging\Query\Query;
use App\SDK\Infrastructure\Exception\QueryHandlerMethodNotFoundException;

/**
 * Convenience base class for query handlers.
 *
 * Query handlers using this base class will implement `handle<QueryName>`
 * methods for each query they can handle.
 *
 * Note: the convention used does not take namespaces into account.
 */
abstract class SimpleQueryHandler implements QueryHandler
{
    /**
     * {@inheritDoc}
     * @throws QueryHandlerMethodNotFoundException
     */
    public function handle(Query $query)
    {
        $method = $this->getHandleMethod($query);

        if (! method_exists($this, $method)) {
            throw new QueryHandlerMethodNotFoundException(static::class, $method);
        }

        return $this->$method($query);
    }

    private function getHandleMethod(Query $query): string
    {
        $classParts = explode('\\', get_class($query));

        return 'handle' . end($classParts);
    }
}
