<?php

namespace App\SDK\Infrastructure\Persistence\User;

use App\SDK\Domain\Model\User\UserId;
use App\SDK\Domain\Service\User\UserIdGenerator;
use App\SDK\Infrastructure\Persistence\Doctrine\DoctrineIdGenerator;

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
