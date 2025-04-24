<?php

namespace Shared\Domain\Messaging\Command\User;

use Shared\Domain\Exception\InvalidParametersException;
use Shared\Domain\Messaging\Command\Command;
use Shared\Domain\Model\User\FirstName;
use Shared\Domain\Model\User\LastName;
use Shared\Domain\Model\User\Password;
use Shared\Domain\Model\User\Username;

class CreateUser implements Command
{
    public function __construct(
        public readonly FirstName $firstName,
        public readonly LastName $lastName,
        public readonly Username $username,
        public readonly Password $password
    ) {
    }

    public static function fromArray(array $data)
    {
        try {
            return new static(
                FirstName::fromString($data['first_name'] ?? null),
                LastName::fromString($data['last_name'] ?? null),
                Username::fromString($data['username'] ?? null),
                Password::fromString($data['password'] ?? null)
            );
        } catch (\Throwable $e) {
            throw new InvalidParametersException(implode(', ', $data));
        }
    }

    public function serialize(): array
    {
        return [
            'first_name' => $this->firstName->firstName(),
            'last_name' => $this->lastName->lastName(),
            'username' => $this->username->userName(),
            'password' => $this->password->password(),
        ];
    }
}
