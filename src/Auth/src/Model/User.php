<?php

declare(strict_types=1);

namespace Auth\Model;

use Auth\Model\Interface\UserInterface;
use function password_verify;

final class User implements UserInterface
{
    public function __construct(
        private string $identity,
        private string $hashedPassword,
        private array $ipAddresses
    )
    {
    }

    public function getIdentity(): string
    {
        return $this->identity;
    }

    public function isPasswordValid(string $password): bool
    {
        return password_verify($password, $this->hashedPassword);
    }

    public function getIpAddresses(): array
    {
        return $this->ipAddresses;
    }

    public function getRoles(): iterable
    {
        return [];
    }

    public function getDetail(string $name, $default = null): mixed
    {
        return $default;
    }

    public function getDetails(): array
    {
        return [];
    }
}
