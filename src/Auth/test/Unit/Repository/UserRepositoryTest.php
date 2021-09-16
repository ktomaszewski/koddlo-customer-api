<?php

declare(strict_types=1);

namespace AuthTest\Unit\Repository;

use Auth\Model\Collection\UserCollection;
use Auth\Model\Interface\UserInterface;
use Auth\Model\User;
use Auth\Repository\UserRepository;
use PHPUnit\Framework\TestCase;

final class UserRepositoryTest extends TestCase
{
    private const USER_VALID_ID = 'validId';
    private const USER_INVALID_ID = 'invalidId';
    private const USER_VALID_PASSWORD = 'validPassword';
    private const USER_INVALID_PASSWORD = 'invalidPassword';
    private const USER_VALID_PASSWORD_HASH = '$2y$10$dKjKO6iC9lP.UVbaCVTZcut51ODnOhUe1rQKC.YA8lMkzUpaGI7WC';

    private UserCollection $users;

    protected function setUp(): void
    {
        $this->users = new UserCollection();
        $this->users->add(new User(self::USER_VALID_ID, self::USER_VALID_PASSWORD_HASH, []));
    }

    private function createUserRepositoryUnderTest(): UserRepository
    {
        return new UserRepository($this->users);
    }

    public function testAuthenticationFailedWhenCredentialIsWrong(): void
    {
        // given
        $userRepository = $this->createUserRepositoryUnderTest();

        // when
        $result = $userRepository->authenticate(self::USER_INVALID_ID, self::USER_VALID_PASSWORD);

        // then
        $this->assertNull($result);
    }

    public function testAuthenticationFailedWhenPasswordIsWrong(): void
    {
        // given
        $userRepository = $this->createUserRepositoryUnderTest();

        // when
        $result = $userRepository->authenticate(self::USER_VALID_ID, self::USER_INVALID_PASSWORD);

        // then
        $this->assertNull($result);
    }

    public function testAuthenticationPassWhenCredentialsAreGood(): void
    {
        // given
        $userRepository = $this->createUserRepositoryUnderTest();

        // when
        $result = $userRepository->authenticate(self::USER_VALID_ID, self::USER_VALID_PASSWORD);

        // then
        $this->assertInstanceOf(UserInterface::class, $result);
    }
}
