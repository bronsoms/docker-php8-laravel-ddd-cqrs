<?php

namespace App\SDK\Domain\Exception;

use Throwable;

class InvalidParametersException extends DomainException
{
    /** @var int */
    protected $code = ExceptionCodes::PARAMS_INVALID;

    public function __construct($message = '', $code = 0, Throwable $previous = null)
    {
        $message = sprintf('Parameters are not valid, got: %s', $message);
        parent::__construct($message, $code, $previous);
    }
}
