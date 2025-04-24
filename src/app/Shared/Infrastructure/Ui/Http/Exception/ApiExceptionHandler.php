<?php

namespace Shared\Infrastructure\Ui\Http\Exception;

use App\Exceptions\Handler as ExceptionHandler;
use Illuminate\Contracts\Container\Container;
use Illuminate\Http\JsonResponse;
use Ramsey\Uuid\Uuid;
use ReflectionClass;

class ApiExceptionHandler extends ExceptionHandler
{
    private ResponseErrorCodeGenerator $errorCodeGenerator;

    public function __construct(
        Container $container,
        ResponseErrorCodeGenerator $errorCodeGenerator
    ) {
        $this->errorCodeGenerator = $errorCodeGenerator;

        parent::__construct($container);
    }

    public function render($request, \Throwable $e)
    {
        $reflect = new ReflectionClass($e);

        $exceptionPayload = [
            'message' => $e->getMessage(),
            'type'    => $reflect->getShortName(),
            'code'    => $e->getCode(),
            'uuid'    => Uuid::uuid4()
        ];

        return new JsonResponse(
            ['error' => $exceptionPayload],
            $this->errorCodeGenerator->responseErrorCodeByExceptionType($e)
        );
    }
}
