<?php

namespace Tests\SDK\Tools\Seeder\User;

use Tests\SDK\Tools\Stub\User\Domain\FirstNameStub;
use Tests\SDK\Tools\Stub\User\Domain\LastNameStub;
use Tests\SDK\Tools\Stub\User\Domain\UserIdStub;
use Tests\SDK\Tools\Seeder\DatabaseSeeder;

class UserSeeder extends DatabaseSeeder
{
    private const TABLE = 'users';

    public static function create(array $params = []): array
    {
        $defaultParameters = [
            'user_id'    => UserIdStub::random()->userId(),
            'first_name' => FirstNameStub::random()->firstName(),
            'last_name'  => LastNameStub::random()->lastName()
        ];

        $values = array_merge($defaultParameters, $params);

        self::insert(self::TABLE, $values);

        return $values;
    }
}
