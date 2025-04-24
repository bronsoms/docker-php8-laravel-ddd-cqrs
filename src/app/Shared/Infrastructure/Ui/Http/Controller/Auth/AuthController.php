<?php

namespace Shared\Infrastructure\Ui\Http\Controller\Auth;

use Shared\Infrastructure\Service\Auth\AuthUserTransformer;
use Shared\Infrastructure\Messaging\QueryBus;
use Symfony\Component\HttpFoundation\Request;
use Shared\Domain\Model\User\Username;

class AuthController
{
    public const LOGIN = 'login';
    public const LOGOUT = 'logout';

    public function __construct(
        private readonly QueryBus $queryBus,
        private readonly AuthUserTransformer $authUserTransformer)
    {
    }

    public function login(Request $request)
    {
        $credentials = [
            'username' => Username::fromString($request->get('username')),
            'password' =>$request->get('password'),
        ];

        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return $this->respondWithToken($token);
    }

    public function logout()
    {
        auth()->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }

    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => $this->authUserTransformer->transform(Auth()->user()),
        ]);
    }
}
