<?php

namespace Shared\Infrastructure\Messaging;

use Shared\Domain\Messaging\Query\Query;

interface QueryHandler
{
    /**
     * @return mixed
     */
    public function handle(Query $query);
}
