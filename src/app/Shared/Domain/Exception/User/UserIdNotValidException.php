<?php

namespace Shared\Domain\Exception\User;

use Shared\Domain\Exception\DomainException;
use Shared\Domain\Exception\ExceptionCodes;

class UserIdNotValidException extends DomainException
{
    /** @var int */
    protected $code = ExceptionCodes::USER_ID_NOT_VALID;

    public function __construct(string $userId = '')
    {
        parent::__construct(sprintf('Invalid user identifier %s ', $userId));
    }
}
