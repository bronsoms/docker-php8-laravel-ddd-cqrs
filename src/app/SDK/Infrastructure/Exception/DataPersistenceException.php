<?php

namespace App\SDK\Infrastructure\Exception;

use Throwable;

class DataPersistenceException extends InfrastructureException
{
    /** @var int */
    protected $code = ExceptionCodes::DATA_PERSISTENCE;

    public function __construct(string $reason, Throwable $previous = null)
    {
        $message = sprintf('There was a persistence problem: %s', $reason);

        parent::__construct($message, $this->code, $previous);
    }
}
