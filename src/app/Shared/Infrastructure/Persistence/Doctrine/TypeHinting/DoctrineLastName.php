<?php

namespace Shared\Infrastructure\Persistence\Doctrine\TypeHinting;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Shared\Domain\Model\User\LastName;
use Doctrine\DBAL\Types\StringType;

class DoctrineLastName extends StringType
{
    public const NAME = 'last_name';

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

        /** @var LastName $value */
        return $value->lastName();
    }

    /**
     * {@inheritdoc}
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if (null === $value || '' === $value) {
            return null;
        }

        return LastName::fromString($value);
    }
}
