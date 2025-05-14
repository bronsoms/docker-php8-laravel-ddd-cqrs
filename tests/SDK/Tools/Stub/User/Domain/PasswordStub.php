<?php

namespace Tests\SDK\Tools\Stub\User\Domain;

use Shared\Domain\Model\User\Password;

class PasswordStub
{
    public static function random(): Password
    {
        return new Password('gj$55BdoXnDlZ');
    }
}