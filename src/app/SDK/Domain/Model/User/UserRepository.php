<?php

namespace App\SDK\Domain\Model\User;

interface UserRepository
{
    public function saveAndEmitEvents(User $user);
}
