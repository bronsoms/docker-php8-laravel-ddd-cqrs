<?php

namespace Shared\Domain\Exception\User;

use Shared\Domain\Exception\DomainException;
use Shared\Domain\Exception\ExceptionCodes;

class FirstNameNotValidException extends DomainException
{
    /** @var int */
    protected $code = ExceptionCodes::FIRST_NAME_NOT_VALID;

    /** @var string */
    protected $message = 'First name is not valid';
}
