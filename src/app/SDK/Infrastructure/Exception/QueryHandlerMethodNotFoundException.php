<?php

namespace App\SDK\Infrastructure\Exception;

class QueryHandlerMethodNotFoundException extends InfrastructureException
{
    /** @var int */
    protected $code = ExceptionCodes::QUERY_HANDLER_METHOD_NOT_FOUND;

    public function __construct($handlerClass, $handlerMethod)
    {
        $message = sprintf('Query handler method %s->%s() not found', $handlerClass, $handlerMethod);

        parent::__construct($message);
    }
}
