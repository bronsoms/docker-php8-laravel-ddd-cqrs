<?php

namespace Shared\Infrastructure\Persistence\User;

use Shared\Domain\Model\User\UserId;
use Shared\Domain\Service\User\UserIdGenerator;
use Shared\Infrastructure\Persistence\Doctrine\DoctrineIdGenerator;

class DoctrineUserIdGenerator extends DoctrineIdGenerator implements UserIdGenerator
{
    public const NAME = 'USERID_COUNTER';

    public function name(): string
    {
        return self::NAME;
    }

    public function next(): UserId
    {
        return UserId::fromString((string) parent::next());
    }
}
