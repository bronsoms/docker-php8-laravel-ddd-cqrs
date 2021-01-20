<?php

namespace App\SDK\Infrastructure\Exception;

class CommandHandlerNotFoundException extends InfrastructureException
{
    /** @var int */
    protected $code = ExceptionCodes::COMMAND_HANDLER_NOT_FOUND;

    public function __construct(string $handlerClass)
    {
        $message = sprintf('Command handler %s not found', $handlerClass);

        parent::__construct($message);
    }
}
