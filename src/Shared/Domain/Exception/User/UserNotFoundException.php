<?php

namespace Shared\Domain\Exception\User;

use Shared\Domain\Exception\DomainException;
use Shared\Domain\Exception\ExceptionCodes;

class UserNotFoundException extends DomainException
{
    /** @var int */
    protected $code = ExceptionCodes::USER_NOT_FOUND;

    /** @var string */
    protected $message = 'User not found';
}
