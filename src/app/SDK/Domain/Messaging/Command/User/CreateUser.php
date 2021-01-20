<?php

namespace App\SDK\Domain\Messaging\Command\User;

use App\SDK\Domain\Exception\InvalidParametersException;
use App\SDK\Domain\Messaging\Command\Command;
use App\SDK\Domain\Model\User\FirstName;
use App\SDK\Domain\Model\User\LastName;
use App\SDK\Domain\Model\User\Password;
use App\SDK\Domain\Model\User\Username;

class CreateUser implements Command
{
    private FirstName $firstName;
    private LastName $lastName;
    private Username $username;
    private Password $password;

    public function __construct(
        FirstName $firstName,
        LastName $lastName,
        Username $username,
        Password $password
    ) {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->username = $username;
        $this->password = $password;
    }

    public function firstName(): FirstName
    {
        return $this->firstName;
    }

    public function lastName(): LastName
    {
        return $this->lastName;
    }

    public function username(): Username
    {
        return $this->username;
    }

    public function password(): Password
    {
        return $this->password;
    }

    public static function fromArray(array $data)
    {
        try {
            return new static(
                $data['first_name'] ?? null,
                $data['last_name'] ?? null,
                $data['username'] ?? null,
                $data['password'] ?? null,
            );
        } catch (\Throwable $e) {
            throw new InvalidParametersException(implode(', ', $data));
        }
    }

    public function serialize(): array
    {
        return [
            'first_name' => $this->firstName()->firstName(),
            'last_name' => $this->lastName()->lastName(),
            'username' => $this->username()->userName(),
            'password' => $this->password()->password(),
        ];
    }
}
