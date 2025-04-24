<?php

namespace Shared\Infrastructure\Persistence\User;

use Shared\Infrastructure\Persistence\Doctrine\BaseDoctrineRepository;
use Shared\Domain\Exception\User\UserNotFoundException;
use Shared\Domain\Model\User\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\ClassMetadata;
use Shared\Domain\Model\User\UserId;
use Shared\Domain\Model\User\User;
use Broadway\EventHandling\EventBus;

class DoctrineUserRepository extends BaseDoctrineRepository implements UserRepository
{
    public function __construct(
        EventBus $eventBus,
        EntityManagerInterface $em,
        ClassMetadata $class
    ) {
        parent::__construct($eventBus, $em, $class);
    }

    /**
     * @throws UserNotFoundException
     */
    public function userOfId(UserId $userId): User
    {
        /** @var User $user */
        $user = $this->find($userId);

        if (!$user) {
            throw new UserNotFoundException();
        }

        return $user;
    }
}
