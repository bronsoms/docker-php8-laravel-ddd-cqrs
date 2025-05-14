<?php

namespace Shared\Infrastructure\Exception;

use Exception;

class InfrastructureException extends Exception
{
    /** @var int */
    protected $code = ExceptionCodes::UNDEFINED;

    /** @var string */
    protected $message = 'General Infrastructure Exception';
}
