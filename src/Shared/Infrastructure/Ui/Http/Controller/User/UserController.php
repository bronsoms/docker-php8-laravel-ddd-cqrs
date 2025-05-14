<?php

namespace Shared\Infrastructure\Ui\Http\Controller\User;

use Shared\Domain\Messaging\Command\User\CreateUser;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Broadway\CommandHandling\CommandBus;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\JsonResponse;

class UserController
{
    public const CREATE_USER = 'createUser';

    public function __construct(
        private readonly CommandBus $commandBus
    ) {
    }

    public function create(Request $request, Guard $guard)
    {
        $this->commandBus->dispatch(CreateUser::fromArray([
            'first_name'   => $request->get('first_name'),
            'last_name'    => $request->get('last_name'),
            'username'     => $request->get('username'),
            'password'     => $request->get('password'),
        ]));

        return new JsonResponse(null, Response::HTTP_CREATED);
    }
}
