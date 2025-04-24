<?php

namespace Shared\Domain\Messaging\Event\User;

use Shared\Domain\Exception\InvalidParametersException;
use Shared\Domain\Messaging\Event\Event;
use Shared\Domain\Model\User\FirstName;
use Shared\Domain\Model\User\Username;
use Shared\Domain\Model\User\LastName;
use Shared\Domain\Model\User\UserId;

class UserCreated implements Event
{
    public const NAME = 'user.created';

    public function __construct(
        public readonly UserId $aggregateId,
        public readonly FirstName $firstName,
        public readonly LastName $lastName,
        public readonly Username $username,
        public readonly string $hashedPassword
    ) {
    }

    public function aggregateId(): UserId
    {
        return $this->aggregateId;
    }

    public function serialize(): array
    {
        return [
            'aggregate_id' => (string) $this->aggregateId(),
            'first_name' => (string) $this->firstName,
            'last_name' => (string) $this->lastName,
            'username' => (string) $this->username,
            'password' => $this->hashedPassword,
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
