<?php

namespace Shared\Domain\Exception;

class DomainException extends \Exception
{
    /** @var int */
    protected $code = ExceptionCodes::UNDEFINED;

    /** @var string */
    protected $message = 'General Domain Exception';
}
