<?php

namespace App\SDK\Infrastructure\Persistence\Doctrine\TypeHinting;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use App\SDK\Domain\Model\User\Username;
use Doctrine\DBAL\Types\StringType;

class DoctrineUsername extends StringType
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'username';
    }

    /**
     * {@inheritdoc}
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if (null === $value) {
            return null;
        }

        /** @var Username $value */
        return $value->username();
    }

    /**
     * {@inheritdoc}
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if (null === $value || '' === $value) {
            return null;
        }

        return Username::fromString($value);
    }
}
