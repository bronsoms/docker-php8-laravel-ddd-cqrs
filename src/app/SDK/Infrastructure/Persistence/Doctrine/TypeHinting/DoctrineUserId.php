<?php

namespace App\SDK\Infrastructure\Persistence\Doctrine\TypeHinting;

use App\SDK\Domain\Model\User\UserId;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\IntegerType;

class DoctrineUserId extends IntegerType
{
    public function getName(): string
    {
        return 'user_id';
    }

    /** @param UserId|null */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?int
    {
        if (null === $value) {
            return null;
        }

        return (int)$value->userId();
    }

    /** @param string|null */
    public function convertToPHPValue($value, AbstractPlatform $platform): ?UserId
    {
        if (null === $value || '' === $value) {
            return null;
        }

        return UserId::fromString($value);
    }
}
