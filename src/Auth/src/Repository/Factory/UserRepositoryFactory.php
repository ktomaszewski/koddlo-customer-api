<?php

declare(strict_types=1);

namespace Auth\Repository\Factory;

use Auth\Model\Collection\UserCollection;
use Auth\Model\User;
use Auth\Repository\UserRepository;
use Interop\Container\ContainerInterface;
use InvalidArgumentException;
use function sprintf;

final class UserRepositoryFactory
{
    public function __invoke(ContainerInterface $container): UserRepository
    {
        $config = $container->get('config');

        $users = new UserCollection();
        foreach ($config['authentication']['users'] ?? [] as $userId => $userData) {
            if (empty($userData['password'])) {
                throw new InvalidArgumentException(sprintf('User (%s) password is required.', $userId));
            }

            $users->add(new User($userId, $userData['password'], $userData['ipAddresses'] ?? []));
        }

        return new UserRepository($users);
    }
}
