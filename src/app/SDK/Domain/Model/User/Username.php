<?php

namespace App\SDK\Domain\Model\User;

use App\SDK\Domain\Exception\User\UsernameNotValidException;
use App\SDK\Domain\Model\ValueObject;

class Username extends ValueObject
{
    public const MAX_LENGTH = 100;
    public const MIN_LENGTH = 5;

    private string $username;

    public function __construct(string $username)
    {
        $this->setUsername($username);
    }

    public function username(): string
    {
        return $this->username;
    }

    public function __toString(): string
    {
        return $this->username();
    }

    public static function fromString(string $username): Username
    {
        return new self($username);
    }

    /**
     * @throws UsernameNotValidException
     */
    private function setUsername(string $username)
    {
        if (self::MIN_LENGTH  > strlen($username)  || self::MAX_LENGTH < strlen($username)) {
            throw new UsernameNotValidException(sprintf(
                'Username length must be more than %s characters long and less than %s',
                self::MIN_LENGTH,
                self::MAX_LENGTH
            ));
        }

        if(!preg_match('/^\S*$/u', $username)) {
            throw new UsernameNotValidException('Username can\'t have blank spaces');
        }

        $this->username = $username;
    }
}
