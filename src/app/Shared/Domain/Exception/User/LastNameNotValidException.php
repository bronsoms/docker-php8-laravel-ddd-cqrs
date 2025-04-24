<?php

namespace Shared\Domain\Exception\User;

use Shared\Domain\Exception\DomainException;
use Shared\Domain\Exception\ExceptionCodes;

class LastNameNotValidException extends DomainException
{
    /** @var int */
    protected $code = ExceptionCodes::LAST_NAME_NOT_VALID;

    /** @var string */
    protected $message = 'Last name is not valid';
}
