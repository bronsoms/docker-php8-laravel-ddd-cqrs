<?php

namespace Tests\SDK\Unit\Infrastructure\Service\Auth;

use App\SDK\Infrastructure\Persistence\User\DoctrineUserRepository;
use App\SDK\Application\Exception\MethodNotImplementedException;
use App\SDK\Infrastructure\Service\Auth\DoctrineUserProvider;
use Tests\SDK\Tools\Stub\User\Domain\PasswordStub;
use Tests\SDK\Tools\Stub\User\Domain\UsernameStub;
use Tests\SDK\Tools\Stub\User\Domain\UserIdStub;
use Tests\SDK\Tools\Stub\User\Domain\UserStub;
use Tests\SDK\Tools\RandomNumberGenerator;
use Doctrine\ORM\EntityManagerInterface;
use Tests\TestCase;

class DoctrineUserProviderTest extends TestCase
{
    /** @var EntityManagerInterface */
    private $entityManager;

    /** @var DoctrineUserRepository  */
    private $userMapper;

    private DoctrineUserProvider $sut;

    protected function setUp(): void
    {
        $this->entityManager = $this->prophesize(EntityManagerInterface::class);
        $this->userMapper = $this->prophesize(DoctrineUserRepository::class);

        $this->sut = new DoctrineUserProvider(
            $this->entityManager->reveal(),
            $this->userMapper->reveal()
        );
    }

    public function testRetrieveByIdShouldReturnUserIfNotNull()
    {
        $userId = UserIdStub::random();
        $user = UserStub::random([
            'user_id' => $userId->userId()
        ]);

        $this->userMapper->find($userId->userId())
            ->shouldBeCalledOnce()
            ->willReturn($user);

        $this->sut->retrieveById($userId->userId());
    }

    public function testRetrieveByIdShouldReturnNullIfNoUserFound()
    {
        $this->userMapper->find(null)
            ->shouldBeCalledOnce()
            ->willReturn(null);

        $this->sut->retrieveById(null);
    }

    public function testRetrieveByCredentialsShouldReturnUser()
    {
        $username = UsernameStub::random();
        $password = PasswordStub::random();

        $credentials = [
            'username' => $username->username(),
            'password' => $password->password()
        ];

        $user = UserStub::create([
            'username' => $username,
            'password' => $password
        ]);

        $this->userMapper->findOneBy(['username' => $username])
            ->shouldBeCalledOnce()
            ->willReturn($user);

        $this->sut->retrieveByCredentials($credentials);
    }

    public function testValidateCredentialsShouldReturnTrue()
    {
        $password = PasswordStub::random();
        $user = UserStub::create([
            'password' => $password->hashed()
        ]);

        static::assertTrue($this->sut->validateCredentials($user, ['password' => $password->password()]));
    }

    public function testValidateCredentialsShouldReturnFalse()
    {
        $password = PasswordStub::random();
        $user = UserStub::create([
            'password' => $password->hashed()
        ]);

        static::assertFalse($this->sut->validateCredentials($user, ['password' => $this->faker()->password]));
    }

    public function testRetrieveByTokenShouldReturnException()
    {
        $this->expectException(MethodNotImplementedException::class);

        $this->sut->retrieveByToken(
            RandomNumberGenerator::integer(),
            RandomNumberGenerator::integer()
        );
    }

    public function testUpdateRememberTokenShouldReturnException()
    {
        $this->expectException(MethodNotImplementedException::class);

        $this->sut->updateRememberToken(
            UserStub::random(),
            RandomNumberGenerator::integer()
        );
    }
}
