<?php

namespace Shared\Infrastructure\Exception;

class QueryHandlerClassNotFoundException extends InfrastructureException
{
    /** @var int */
    protected $code = ExceptionCodes::QUERY_HANDLER_CLASS_NOT_FOUND;

    public function __construct($handlerClass)
    {
        $message = sprintf('Query handler class %s not found', $handlerClass);

        parent::__construct($message);
    }
}
