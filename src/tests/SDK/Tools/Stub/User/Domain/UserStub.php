<?php

namespace Tests\SDK\Tools\Stub\User\Domain;

use App\SDK\Domain\Model\User\User;
use Faker\Factory;

class UserStub
{
    public static function create(array $params = []): User
    {
        $faker = Factory::create();

        $defaultParameters = [
            'user_id' => UserIdStub::random(),
            'first_name' => FirstNameStub::random(),
            'last_name' => LastNameStub::random(),
            'username' => UsernameStub::random(),
            'password' => $faker->password
        ];

        $parameters = array_merge($defaultParameters, $params);

        return new User(
            $parameters['user_id'],
            $parameters['first_name'],
            $parameters['last_name'],
            $parameters['username'],
            $parameters['password'],
        );
    }

    public static function random(): User
    {
        return self::create([]);
    }
}