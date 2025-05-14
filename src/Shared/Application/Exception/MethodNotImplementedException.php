<?php

namespace Shared\Application\Exception;

class MethodNotImplementedException extends ApplicationException
{
    /** @var int */
    protected $code = ExceptionCodes::METHOD_NOT_IMPLEMENTED;

    public function __construct(string $method, string $class)
    {
        parent::__construct(sprintf('Method %s not implement for class %s', $method, $class));
    }
}
