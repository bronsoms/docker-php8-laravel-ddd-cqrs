<?php

namespace App\SDK\Infrastructure\Ui\Http\Exception;

use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Illuminate\Contracts\Queue\EntityNotFoundException;
use App\SDK\Application\Exception\ApplicationException;
use Illuminate\Auth\Access\AuthorizationException;
use App\SDK\Domain\Exception\DomainException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Response;

class ResponseErrorCodeGenerator
{
    public function responseErrorCodeByExceptionType(\Throwable $e): int
    {
        switch (true) {
            case $e instanceof EntityNotFoundException:
                $retval = Response::HTTP_NOT_FOUND;
                break;
            case $e instanceof AuthorizationException:
            case $e instanceof AuthenticationException:
            case $e instanceof UnauthorizedHttpException:
                $retval = Response::HTTP_UNAUTHORIZED;
                break;
            case $e instanceof DomainException:
            case $e instanceof ApplicationException:
                $retval = Response::HTTP_BAD_REQUEST;
                break;
            default:
                $retval = Response::HTTP_INTERNAL_SERVER_ERROR;
        }

        return $retval;
    }
}
