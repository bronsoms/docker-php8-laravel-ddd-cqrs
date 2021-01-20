<?php

namespace App\SDK\Domain\Model\User;

use App\SDK\Application\Service\Enum;

class UserType extends Enum
{
    public const ADMIN = 'ADMIN';
    public const CHEF = 'CHEF';
    // TODO: Afegir cambrer;
    public const HIRED_DELIVERY = 'HIRED_DELIVERY';
    public const TEMPORARY_DELIVERY = 'TEMPORARY_DELIVERY';
}
