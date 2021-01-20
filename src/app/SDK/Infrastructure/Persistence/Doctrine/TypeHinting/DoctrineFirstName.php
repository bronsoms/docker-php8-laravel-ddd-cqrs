<?php

namespace App\SDK\Infrastructure\Persistence\Doctrine\TypeHinting;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use App\SDK\Domain\Model\User\FirstName;
use Doctrine\DBAL\Types\StringType;

class DoctrineFirstName extends StringType
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'first_name';
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
