<?php

namespace App\SDK\Domain\Exception\User;

use App\SDK\Domain\Exception\DomainException;
use App\SDK\Domain\Exception\ExceptionCodes;

class PasswordNotValidException extends DomainException
{
    /** @var int */
    protected $code = ExceptionCodes::PASSWORD_NOT_VALID;

    public function __construct(string $reason)
    {
        parent::__construct($reason);
    }
}
