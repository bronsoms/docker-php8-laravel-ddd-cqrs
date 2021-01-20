<?php

namespace App\SDK\Domain\Exception\User;

use App\SDK\Domain\Exception\DomainException;
use App\SDK\Domain\Exception\ExceptionCodes;

class UserNotFoundException extends DomainException
{
    /** @var int */
    protected $code = ExceptionCodes::USER_NOT_FOUND;

    /** @var string */
    protected $message = 'User not found';
}
