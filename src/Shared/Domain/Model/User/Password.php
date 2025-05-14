<?php

namespace Shared\Domain\Model\User;

use Shared\Domain\Exception\User\PasswordNotValidException;

class Password
{
    public const MINIMAL_NUMBER_OF_CHARACTERS = 8;

    private string $password;

    /**
     * @throws PasswordNotValidException
     */
    public function __construct(string $password)
    {
        $this->setPassword($password);
    }

    /**
     * @throws PasswordNotValidException
     */
    private function setPassword(string $password)
    {
        $this->validate($password);

        $this->password = $password;
    }

    public function password(): string
    {
        return $this->password;
    }

    public static function fromString(string $password)
    {
        return new static($password);
    }

    public function __toString(): string
    {
        return $this->password();
    }

    public function hashed(): string
    {
        return password_hash($this->password(), PASSWORD_BCRYPT, ['cost' => 12]);
    }

    /**
     * @throws PasswordNotValidException
     */
    private function validate(string $password): void
    {
        // Uppercase
        if (!preg_match('@[A-Z]@', $password)) {
            throw new PasswordNotValidException('The password should have at least 1 uppercase letter.');
        }

        // Lowercase
        if (!preg_match('@[a-z]@', $password)) {
            throw new PasswordNotValidException('The password should have at least 1 lowercase letter.');
        }

        // Number
        if (!preg_match('@[0-9]@', $password)) {
            throw new PasswordNotValidException('The password should have at least 1 number.');
        }

        // Special Char
        if (!preg_match('@[^\w]@', $password)) {
            throw new PasswordNotValidException('The password should have at least 1 special character.');
        }

        // Length
        if (strlen($password) < self::MINIMAL_NUMBER_OF_CHARACTERS) {
            throw new PasswordNotValidException(sprintf(
                "The password should have at least %s characters.",
                self::MINIMAL_NUMBER_OF_CHARACTERS
            ));
        }
    }
}
