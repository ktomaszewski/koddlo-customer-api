<?php

declare(strict_types=1);

namespace Auth\Repository;

use Auth\Model\Collection\UserCollection;
use Auth\Repository\Interface\UserRepositoryInterface;
use Mezzio\Authentication\UserInterface;

final class UserRepository implements UserRepositoryInterface
{
    public function __construct(private UserCollection $users)
    {
    }

    public function authenticate(string $credential, ?string $password = null): ?UserInterface
    {
        $user = $this->users->get($credential);

        return $user?->isPasswordValid($password) ? $user : null;
    }
}
