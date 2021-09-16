<?php

declare(strict_types=1);

namespace AuthTest\Unit\Model;

use Auth\Model\User;
use PHPUnit\Framework\TestCase;

final class UserTest extends TestCase
{
    public function testCanVerifyPassword(): void
    {
        // given
        $validPassword = 'validPassword';
        $invalidPassword = 'invalidPassword';
        $validPasswordHash = '$2y$10$dKjKO6iC9lP.UVbaCVTZcut51ODnOhUe1rQKC.YA8lMkzUpaGI7WC';

        $user = new User('testId', $validPasswordHash, []);

        // then
        $this->assertFalse($user->isPasswordValid($invalidPassword));
        $this->assertTrue($user->isPasswordValid($validPassword));
    }
}
