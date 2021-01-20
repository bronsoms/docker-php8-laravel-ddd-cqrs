<?php

namespace Tests\SDK\Tools\Stub\User\Domain;

use Tests\SDK\Tools\RandomNumberGenerator;
use App\SDK\Domain\Model\User\UserId;

class UserIdStub
{
    public static function random(): UserId
    {
        return UserId::fromString(RandomNumberGenerator::integer());
    }
}