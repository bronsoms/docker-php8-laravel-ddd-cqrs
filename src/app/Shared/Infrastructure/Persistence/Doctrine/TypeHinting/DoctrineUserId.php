<?php

namespace Shared\Infrastructure\Persistence\Doctrine\TypeHinting;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Shared\Domain\Model\User\UserId;
use Doctrine\DBAL\Types\IntegerType;

class DoctrineUserId extends IntegerType
{
    public const NAME = 'user_id';

    public function getName(): string
    {
        return self::NAME;
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
