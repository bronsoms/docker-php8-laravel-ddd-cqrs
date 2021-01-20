<?php

namespace Tests\SDK\Integration\Infrastructure\Persistence\User;

use App\SDK\Domain\Exception\User\UserNotFoundException;
use Tests\SDK\Tools\Stub\User\Domain\UserIdStub;
use App\SDK\Domain\Model\User\UserRepository;
use Tests\SDK\Tools\Seeder\User\UserSeeder;
use App\SDK\Domain\Model\User\User;
use Tests\DatabaseTestCase;

class DoctrineUserRepositoryTest extends DatabaseTestCase
{
    private UserRepository $sut;

    public function setUp(): void
    {
        parent::setUp();
        
        $this->sut = $this->app->make(UserRepository::class);
    }

    public function test_can_get_user()
    {
        $userId = UserIdStub::random();

        UserSeeder::create([
            'user_id' => $userId
        ]);

        $user = $this->sut->userOfId($userId);

        static::assertInstanceOf(User::class, $user);
        static::assertEquals($userId, $user->userId());
    }

    public function test_throws_exception_on_user_not_found()
    {
        $this->expectException(UserNotFoundException::class);

        $this->sut->userOfId(UserIdStub::random());
    }
}
