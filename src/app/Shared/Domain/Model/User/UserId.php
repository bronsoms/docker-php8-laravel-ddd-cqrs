<?php

namespace Shared\Domain\Model\User;

use Shared\Domain\Exception\User\UserIdNotValidException;
use Shared\Domain\Model\ValueObject;
use Assert\Assertion;

final class UserId extends ValueObject
{
    private string $userId;

    private function __construct(string $userId)
    {
        $this->setId($userId);
    }

    /**
     * @throws UserIdNotValidException
     */
    public static function fromString(string $userId): UserId
    {
        try {
            return new self($userId);
        } catch (\Throwable $e) {
            throw new UserIdNotValidException($userId);
        }
    }

    public function userId(): string
    {
        return $this->userId;
    }

    private function setId(string $userId)
    {
        Assertion::integerish($userId);
        Assertion::greaterThan($userId, 0);

        $this->userId = $userId;
    }

    public function __toString(): string
    {
        return $this->userId();
    }
}
