<?php

declare(strict_types=1);

namespace Auth;

use Auth\Middleware\Factory\IpAccessControlMiddlewareFactory;
use Auth\Middleware\IpAccessControlMiddleware;
use Auth\Repository\Factory\UserRepositoryFactory;
use Auth\Repository\UserRepository;
use Mezzio\Authentication\AuthenticationInterface;
use Mezzio\Authentication\Basic\BasicAccess;
use Mezzio\Authentication\UserRepositoryInterface;

final class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            'dependencies' => $this->getDependencies(),
        ];
    }

    public function getDependencies(): array
    {
        return [
            'aliases'   => [
                UserRepositoryInterface::class => UserRepository::class,
                AuthenticationInterface::class => BasicAccess::class,
            ],
            'factories' => [
                UserRepository::class            => UserRepositoryFactory::class,
                IpAccessControlMiddleware::class => IpAccessControlMiddlewareFactory::class,
            ],
        ];
    }
}
