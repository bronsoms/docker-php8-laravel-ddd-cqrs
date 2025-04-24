<?php

namespace Shared\Domain\Exception;

class ExceptionCodes
{
    public const UNDEFINED = 0;

    // Generic
    public const PARAMS_INVALID = 1001;

    // User
    public const USER_ID_NOT_VALID = 1100;
    public const FIRST_NAME_NOT_VALID = 1101;
    public const LAST_NAME_NOT_VALID = 1102;
    public const USERNAME_NOT_VALID = 1103;
    public const PASSWORD_NOT_VALID = 1104;
    public const USER_NOT_FOUND = 1110;
}
