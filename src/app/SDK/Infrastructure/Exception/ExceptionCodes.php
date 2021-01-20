<?php

namespace App\SDK\Infrastructure\Exception;

class ExceptionCodes
{
    public const UNDEFINED = 0;

    // Database
    public const DATA_PERSISTENCE = 1000;

    // Messaging
    public const QUERY_HANDLER_CLASS_NOT_FOUND = 2000;
    public const QUERY_HANDLER_METHOD_NOT_FOUND = 2001;
    public const COMMAND_HANDLER_NOT_FOUND = 2002;
}