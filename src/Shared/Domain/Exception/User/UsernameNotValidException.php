<?php

namespace Shared\Domain\Exception\User;

use Shared\Domain\Exception\DomainException;
use Shared\Domain\Exception\ExceptionCodes;

class UsernameNotValidException extends DomainException
{
    /** @var int */
    protected $code = ExceptionCodes::USERNAME_NOT_VALID;

    public function __construct(string $reason)
    {
        parent::__construct(sprintf('Username is not valid. Reason: %s', $reason));
    }
}
