<?php

namespace Tests\SDK\Tools\Stub\User\Domain;

use App\SDK\Domain\Model\User\Username;
use Faker\Factory;

class UsernameStub
{
    public static function random(): Username
    {
        $faker = Factory::create();
        return new Username(mb_strcut($faker->userName, 0, Username::MAX_LENGTH));
    }
}