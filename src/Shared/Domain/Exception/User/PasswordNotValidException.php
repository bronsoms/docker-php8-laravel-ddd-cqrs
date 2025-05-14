<?php

namespace Shared\Domain\Exception\User;

use Shared\Domain\Exception\DomainException;
use Shared\Domain\Exception\ExceptionCodes;

class PasswordNotValidException extends DomainException
{
    /** @var int */
    protected $code = ExceptionCodes::PASSWORD_NOT_VALID;

    public function __construct(string $reason)
    {
        parent::__construct($reason);
    }
}
