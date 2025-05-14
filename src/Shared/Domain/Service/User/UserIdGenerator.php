<?php

namespace Shared\Domain\Service\User;

use Shared\Application\Service\IdGenerator;
use Shared\Domain\Model\User\UserId;

interface UserIdGenerator extends IdGenerator
{
    public function next(): UserId;
}
