<?php

namespace Tests\SDK\Unit\Infrastructure\Providers;

use App\SDK\Infrastructure\Persistence\User\DoctrineUserIdGenerator;
use App\SDK\Infrastructure\Persistence\User\DoctrineUserRepository;
use App\SDK\Infrastructure\Providers\DoctrineServiceProvider;
use App\SDK\Infrastructure\Providers\UserServiceProvider;
use Illuminate\Contracts\Foundation\Application;
use App\SDK\Domain\Service\User\UserIdGenerator;
use App\SDK\Domain\Model\User\UserRepository;
use Doctrine\ORM\Mapping\ClassMetadata;
use Broadway\EventHandling\EventBus;
use App\SDK\Domain\Model\User\User;
use Tests\ServiceProviderTestCase;
use Doctrine\ORM\EntityManager;

class UserServiceProviderTest extends ServiceProviderTestCase
{
    /** @var Application */
    private $application;

    private UserServiceProvider $sut;

    protected function setUp(): void
    {
        $this->application = $this->prophesize(Application::class);
        $this->sut = new UserServiceProvider($this->application->reveal());
    }

    public function testRegisterShouldBeValid()
    {
        $this->mockAppBind(
            $this->application,
            UserRepository::class,
            function () {
                $classMetadata = $this->prophesize(ClassMetadata::class);
                $em = $this->prophesize(EntityManager::class);
                $em->getClassMetadata(User::class)->shouldBeCalled()->willReturn($classMetadata);

                $this->registerMakeWithReturnReveal($this->application, DoctrineServiceProvider::ENTITY_MANAGER, $em);

                return new DoctrineUserRepository(
                    $this->registerMakeRevealed($this->application, EventBus::class),
                    $em->reveal(),
                    $classMetadata->reveal(),
                );
            }
        );

        $this->mockAppBind($this->application, UserIdGenerator::class, function () {
            $em = $this->prophesize(EntityManager::class);

            return new DoctrineUserIdGenerator(
                $em->reveal()
            );
        });

        $this->sut->register();
    }

    public function test_provides_should_be_valid()
    {
        $expected = [
            UserRepository::class,
            UserIdGenerator::class,
        ];

        static::assertEquals($expected, $this->sut->provides());
    }
}
