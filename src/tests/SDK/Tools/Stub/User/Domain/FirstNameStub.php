<?php

namespace Tests\SDK\Tools\Stub\User\Domain;

use App\SDK\Domain\Model\User\FirstName;
use Faker\Factory;

class FirstNameStub
{
    public static function random(): FirstName
    {
        $faker = Factory::create();
        return new FirstName(mb_strcut($faker->firstName, 0, FirstName::MAX_LENGTH));
    }
}