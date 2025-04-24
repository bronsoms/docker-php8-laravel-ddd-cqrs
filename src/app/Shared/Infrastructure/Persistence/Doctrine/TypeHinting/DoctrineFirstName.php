<?php

namespace Shared\Infrastructure\Persistence\Doctrine\TypeHinting;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Shared\Domain\Model\User\FirstName;
use Doctrine\DBAL\Types\StringType;

class DoctrineFirstName extends StringType
{
    public const NAME = 'first_name';

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return self::NAME;
    }

    /**
     * {@inheritdoc}
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if (null === $value) {
            return null;
        }

        /** @var FirstName $value */
        return $value->firstName();
    }

    /**
     * {@inheritdoc}
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if (null === $value || '' === $value) {
            return null;
        }

        return FirstName::fromString($value);
    }
}
