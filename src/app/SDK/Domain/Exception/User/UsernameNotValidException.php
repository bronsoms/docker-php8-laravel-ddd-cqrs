<?php

namespace App\SDK\Domain\Exception\User;

use App\SDK\Domain\Exception\DomainException;
use App\SDK\Domain\Exception\ExceptionCodes;

class UsernameNotValidException extends DomainException
{
    /** @var int */
    protected $code = ExceptionCodes::USERNAME_NOT_VALID;

    public function __construct(string $reason)
    {
        parent::__construct(sprintf('Username is not valid. Reason: %s', $reason));
    }
}
