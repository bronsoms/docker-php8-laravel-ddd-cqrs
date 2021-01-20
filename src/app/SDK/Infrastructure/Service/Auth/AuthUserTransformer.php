<?php

namespace App\SDK\Infrastructure\Service\Auth;

use App\SDK\Domain\Model\User\User;

class AuthUserTransformer
{
    public function transform(User $user)
    {
        return [
            'id' => $user->userId()->userId(),
        ];
    }
}