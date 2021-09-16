<?php

declare(strict_types=1);

namespace Auth\Model\Collection;

use Auth\Model\Interface\UserInterface;
use Auth\Model\User;

final class UserCollection
{
    /** @var User[] */
    private array $users = [];

    public function get(string $id): ?User
    {
        return $this->users[$id] ?? null;
    }

    public function add(UserInterface $user): self
    {
        $this->users[$user->getIdentity()] = $user;
        return $this;
    }
}
