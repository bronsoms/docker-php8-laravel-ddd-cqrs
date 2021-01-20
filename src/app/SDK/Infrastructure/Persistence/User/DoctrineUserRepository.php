<?php

namespace App\SDK\Infrastructure\Persistence\User;

use App\SDK\Infrastructure\Persistence\Doctrine\BaseDoctrineRepository;
use App\SDK\Domain\Exception\User\UserNotFoundException;
use App\SDK\Domain\Model\User\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\ClassMetadata;
use App\SDK\Domain\Model\User\UserId;
use App\SDK\Domain\Model\User\User;
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
