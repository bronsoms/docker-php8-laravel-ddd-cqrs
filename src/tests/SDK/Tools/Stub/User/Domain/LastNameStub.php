<?php

namespace Tests\SDK\Tools\Stub\User\Domain;

use App\SDK\Domain\Model\User\LastName;
use Faker\Factory;

class LastNameStub
{
    public static function random(): LastName
    {
        $faker = Factory::create();
        return new LastName(mb_strcut($faker->lastName, 0, LastName::MAX_LENGTH));
    }
}