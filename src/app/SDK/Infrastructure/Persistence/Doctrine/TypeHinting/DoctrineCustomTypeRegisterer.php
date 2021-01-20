<?php

namespace App\SDK\Infrastructure\Persistence\Doctrine\TypeHinting;

use Doctrine\DBAL\Types\Type;

class DoctrineCustomTypeRegisterer
{
    public static function registerTypes()
    {
        $types = DoctrineCustomTypes::$mapping;

        foreach ($types as $name => $type) {
            if (!Type::hasType($name)) {
                Type::addType($name, $type);
            }
        }
    }
}
