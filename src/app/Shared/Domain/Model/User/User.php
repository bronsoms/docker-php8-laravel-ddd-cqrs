<?php

namespace Shared\Domain\Model\User;

use Shared\Domain\Model\Auth\PersonalAccessToken;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Shared\Domain\Messaging\Event\User\UserCreated;
use Shared\Domain\Service\EventSourcedAggregateRoot;
use Shared\Domain\Model\AggregateRoot;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject, AggregateRoot
{
    use EventSourcedAggregateRoot;


    /** @var PersonalAccessToken[]|Collection */
    private Collection $tokens;

    public function __construct(
        private UserId $userId,
        private FirstName $firstName,
        private LastName $lastName,
        private Username $username,
        private string $password,
        private ?string $rememberToken,
    ) {
    }

    public static function createUser(
        UserId $userId,
        FirstName $firstName,
        LastName $lastName,
        Username $username,
        Password $password
    ): self {
        $hashedPassword = $password->hashed();

        $user = new self(
            $userId,
            $firstName,
            $lastName,
            $username,
            $hashedPassword,
            null
        );

        $user->addEvent(new UserCreated(
            $userId,
            $firstName,
            $lastName,
            $username,
            $hashedPassword
        ));

        return $user;
    }

    public function userId(): UserId
    {
        return $this->userId;
    }

    public function getAggregateRootId(): UserId
    {
        return $this->userId();
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

    public function password(): string
    {
        return $this->password;
    }

    public function getAuthPassword()
    {
        return $this->password;
    }

    public function getJWTIdentifier()
    {
        return $this->userId()->userId();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
