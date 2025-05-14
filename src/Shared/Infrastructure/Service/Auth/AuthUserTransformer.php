<?php

namespace Shared\Infrastructure\Service\Auth;

use Shared\Domain\Model\User\User;

class AuthUserTransformer
{
    public function transform(User $user)
    {
        return [
            'id' => $user->userId()->userId(),
        ];
    }
}