<?php

namespace SDK\Infrastructure\Ui\Http\Controller\User;

use App\SDK\Domain\Messaging\Command\User\CreateUser;
use App\SDK\Domain\Model\User\Password;
use App\SDK\Domain\Model\User\Username;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\SDK\Domain\Model\User\FirstName;
use Broadway\CommandHandling\CommandBus;
use App\SDK\Domain\Model\User\LastName;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\JsonResponse;

class UserController
{
    public const CREATE_USER = 'createUser';

    private CommandBus $commandBus;

    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    public function create(Request $request, Guard $guard)
    {
        $firstName = $request->get('first_name');
        $lastName = $request->get('last_name');
        $username = $request->get('username');
        $password = $request->get('password');

        $this->commandBus->dispatch(CreateUser::fromArray([
            'first_name'   => FirstName::fromString($firstName),
            'last_name'    => LastName::fromString($lastName),
            'username'     => Username::fromString($username),
            'password'     => Password::fromString($password)
        ]));

        return new JsonResponse(null, Response::HTTP_CREATED);
    }
}
