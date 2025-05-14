<?php

namespace Shared\Domain\Model;

abstract class ValueObject
{
    abstract public function __toString(): string;

    /**
     * @param mixed $object
     */
    public function equals($object): bool
    {
        return (($object instanceof self) && $object->__toString() === $this->__toString());
    }
}
