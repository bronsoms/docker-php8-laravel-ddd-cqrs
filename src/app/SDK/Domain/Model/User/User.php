<?php

namespace App\SDK\Domain\Model\User;

use App\SDK\Domain\Model\Auth\PersonalAccessToken;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\SDK\Domain\Messaging\Event\User\UserCreated;
use App\SDK\Domain\Service\EventSourcedAggregateRoot;
use App\SDK\Domain\Model\AggregateRoot;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject, AggregateRoot
{
    use EventSourcedAggregateRoot;

    private UserId $userId;
    private FirstName $firstName;
    private LastName $lastName;
    private Username $username;
    private string $password;
    private ?string $rememberToken;

    /** @var PersonalAccessToken[]|Collection */
    private Collection $tokens;

    public function __construct(
        UserId $userId,
        FirstName $firstName,
        LastName $lastName,
        Username $username,
        string $password
    ) {
        $this->userId = $userId;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->username = $username;
        $this->password = $password;
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
            $hashedPassword
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
