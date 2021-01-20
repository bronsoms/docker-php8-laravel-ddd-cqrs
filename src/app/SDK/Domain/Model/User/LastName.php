<?php

namespace App\SDK\Domain\Model\User;

use App\SDK\Domain\Exception\User\LastNameNotValidException;
use App\SDK\Domain\Model\ValueObject;

class LastName extends ValueObject
{
    public const MAX_LENGTH = 255;
    public const MIN_LENGTH = 1;

    private string $lastName;

    public function __construct(string $lastName)
    {
        $this->setLastName($lastName);
    }

    public function lastName(): string
    {
        return $this->lastName;
    }

    public function __toString(): string
    {
        return $this->lastName();
    }

    public static function fromString(string $lastName): LastName
    {
        return new self($lastName);
    }

    /**
     * @throws LastNameNotValidException
     */
    private function setLastName(string $lastName)
    {
        if (self::MIN_LENGTH  > strlen($lastName)  || self::MAX_LENGTH < strlen($lastName)) {
            throw new LastNameNotValidException();
        }

        $this->lastName = $lastName;
    }
}
