<?php

namespace App\SDK\Infrastructure\Messaging;

use App\SDK\Domain\Messaging\Query\Query;

interface QueryHandler
{
    /**
     * @return mixed
     */
    public function handle(Query $query);
}
