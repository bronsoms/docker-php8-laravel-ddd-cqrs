<?php

namespace App\SDK\Application\Exception;

use Exception;

class ApplicationException extends Exception
{
    /** @var int */
    protected $code = ExceptionCodes::UNDEFINED;

    /** @var string */
    protected $message = 'General Application Exception';
}
