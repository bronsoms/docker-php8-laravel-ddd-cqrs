<?php

namespace App\SDK\Infrastructure\Persistence\Doctrine\TypeHinting;

class DoctrineCustomTypes
{
    public static $mapping = [
        'user_id' => DoctrineUserId::class,
        'first_name' => DoctrineFirstName::class,
        'last_name' => DoctrineLastName::class,
        'username' => DoctrineUsername::class,
    ];
}
