<?php

namespace App\SDK\Domain\Exception\User;

use App\SDK\Domain\Exception\DomainException;
use App\SDK\Domain\Exception\ExceptionCodes;

class FirstNameNotValidException extends DomainException
{
    /** @var int */
    protected $code = ExceptionCodes::FIRST_NAME_NOT_VALID;

    /** @var string */
    protected $message = 'First name is not valid';
}
