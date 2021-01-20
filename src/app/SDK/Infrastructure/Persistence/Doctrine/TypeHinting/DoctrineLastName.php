<?php

namespace App\SDK\Infrastructure\Persistence\Doctrine\TypeHinting;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use App\SDK\Domain\Model\User\LastName;
use Doctrine\DBAL\Types\StringType;

class DoctrineLastName extends StringType
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'last_name';
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
