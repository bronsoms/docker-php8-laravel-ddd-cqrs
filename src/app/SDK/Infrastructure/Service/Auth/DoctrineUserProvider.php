<?php

namespace App\SDK\Infrastructure\Service\Auth;

use App\SDK\Application\Exception\MethodNotImplementedException;
use Illuminate\Contracts\Auth\Authenticatable as UserContract;
use App\SDK\Domain\Model\User\UserRepository;
use Illuminate\Contracts\Auth\UserProvider;
use Doctrine\ORM\EntityManagerInterface;
use App\SDK\Domain\Model\User\UserId;

class DoctrineUserProvider implements UserProvider
{
    private EntityManagerInterface $em;
    private UserRepository $userMapper;

    public function __construct(EntityManagerInterface $entityManager, UserRepository $userMapper)
    {
        $this->em = $entityManager;
        $this->userMapper = $userMapper;
    }

    public function retrieveById($identifier)
    {
        if ($identifier && !$identifier instanceof UserId) {
            $identifier = UserId::fromString($identifier);
        }

        return $this->userMapper->find($identifier);
    }

    public function retrieveByCredentials(array $credentials)
    {
        $criteria = [];
        foreach ($credentials as $key => $value) {
            if (!str_contains($key, 'password')) {
                $criteria[$key] = $value;
            }
        }

        return $this->userMapper->findOneBy($criteria);
    }

    public function validateCredentials(UserContract $user, array $credentials)
    {
        $userPass = $user->getAuthPassword();
        $pass = $credentials['password'];
        return password_verify($pass, $userPass);
    }

    public function retrieveByToken($identifier, $token)
    {
        throw new MethodNotImplementedException('retrieveByToken', __CLASS__);
    }

    public function updateRememberToken(UserContract $user, $token)
    {
        throw new MethodNotImplementedException('updateRememberToken', __CLASS__);
    }
}
