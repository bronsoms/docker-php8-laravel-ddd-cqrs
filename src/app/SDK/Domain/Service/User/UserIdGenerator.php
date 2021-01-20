<?php

namespace App\SDK\Domain\Service\User;

use App\SDK\Application\Service\IdGenerator;
use App\SDK\Domain\Model\User\UserId;

interface UserIdGenerator extends IdGenerator
{
    public function next(): UserId;
}
