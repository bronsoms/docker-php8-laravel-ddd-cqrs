<?php

namespace App\SDK\Domain\Exception\User;

use App\SDK\Domain\Exception\DomainException;
use App\SDK\Domain\Exception\ExceptionCodes;

class LastNameNotValidException extends DomainException
{
    /** @var int */
    protected $code = ExceptionCodes::LAST_NAME_NOT_VALID;

    /** @var string */
    protected $message = 'Last name is not valid';
}
