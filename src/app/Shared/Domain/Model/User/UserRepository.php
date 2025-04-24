<?php

namespace Shared\Domain\Model\User;

interface UserRepository
{
    public function saveAndEmitEvents(User $user);
}
