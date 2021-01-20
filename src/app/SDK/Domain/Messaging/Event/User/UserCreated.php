<?php

namespace App\SDK\Domain\Messaging\Event\User;

use App\SDK\Domain\Exception\InvalidParametersException;
use App\SDK\Domain\Messaging\Event\Event;
use App\SDK\Domain\Model\User\FirstName;
use App\SDK\Domain\Model\User\LastName;
use App\SDK\Domain\Model\User\UserId;
use App\SDK\Domain\Model\User\Username;

class UserCreated implements Event
{
    public const NAME = 'user.created';

    private UserId $aggregateId;
    private FirstName $firstName;
    private LastName $lastName;
    private Username $username;
    private string $hashedPassword;

    public function __construct(
        UserId $userId,
        FirstName $firstName,
        LastName $lastName,
        Username $username,
        string $hashedPassword
    ) {
        $this->aggregateId = $userId;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->username = $username;
        $this->hashedPassword = $hashedPassword;
    }

    public function aggregateId(): UserId
    {
        return $this->aggregateId;
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

    public function hashedPassword(): string
    {
        return $this->hashedPassword;
    }

    public function serialize(): array
    {
        return [
            'aggregate_id' => (string) $this->aggregateId(),
            'first_name' => (string) $this->firstName(),
            'last_name' => (string) $this->lastName(),
            'username' => (string) $this->username(),
            'password' => $this->hashedPassword(),
        ];
    }

    /**
     * @inheritdoc
     */
    public static function fromArray(array $data): self
    {
        try {
            return new static(
                $data['aggregate_id'] ?? null,
                $data['first_name'] ?? null,
                $data['last_name'] ?? null,
                $data['username'] ?? null,
                $data['password'] ?? null
            );
        } catch (\Throwable $e) {
            throw new InvalidParametersException(implode(', ', $data));
        }
    }

    public function name(): string
    {
        return self::NAME;
    }
}
