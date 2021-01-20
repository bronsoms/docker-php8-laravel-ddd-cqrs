<?php

namespace App\SDK\Domain\Model\User;

use App\SDK\Domain\Exception\User\FirstNameNotValidException;
use App\SDK\Domain\Model\ValueObject;

class FirstName extends ValueObject
{
    public const MAX_LENGTH = 255;

    public const MIN_LENGTH = 1;

    private string $firstName;

    public function __construct(string $firstName)
    {
        $this->setFirstName($firstName);
    }

    public function firstName(): string
    {
        return $this->firstName;
    }

    public function __toString(): string
    {
        return $this->firstName();
    }

    public static function fromString(string $firstName): FirstName
    {
        return new self($firstName);
    }

    /**
     * @throws FirstNameNotValidException
     */
    private function setFirstName(string $firstName)
    {
        if (self::MIN_LENGTH > strlen($firstName) || self::MAX_LENGTH < strlen($firstName)) {
            throw new FirstNameNotValidException();
        }

        $this->firstName = $firstName;
    }
}
