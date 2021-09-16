<?php

declare(strict_types=1);

namespace AuthTest\Unit\Middleware;

use Auth\Middleware\IpAccessControlMiddleware;
use Auth\Model\Interface\UserInterface;
use Auth\Model\User;
use Mezzio\Authentication\AuthenticationInterface;
use Mezzio\Authentication\UserInterface as AuthUserInterface;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Prophecy\Prophecy\ObjectProphecy;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class IpAccessControlMiddlewareTest extends TestCase
{
    use ProphecyTrait;

    private ServerRequestInterface|ObjectProphecy $request;
    private RequestHandlerInterface|ObjectProphecy $requestHandler;
    private AuthenticationInterface|ObjectProphecy $authentication;

    protected function setUp(): void
    {
        $this->request = $this->prophesize(ServerRequestInterface::class);
        $this->requestHandler = $this->prophesize(RequestHandlerInterface::class);
        $this->authentication = $this->prophesize(AuthenticationInterface::class);
    }

    private function createIpAccessControlMiddlewareUnderTest(): IpAccessControlMiddleware
    {
        return new IpAccessControlMiddleware($this->authentication->reveal());
    }

    public function testCannotAccessWithWrongIpAddress(): void
    {
        // expect
        $user = new User('testId', 'hashedPassword', ['196.168.0.1']);
        $this->request
            ->getAttribute(AuthUserInterface::class)
            ->willReturn($user);

        $this->request
            ->getServerParams()
            ->willReturn(['REMOTE_ADDR' => '127.0.0.1']);

        $this->authentication
            ->unauthorizedResponse($this->request->reveal())
            ->shouldBeCalled();

        // given
        $ipAccessControlMiddleware = $this->createIpAccessControlMiddlewareUnderTest();

        // when
        $ipAccessControlMiddleware->process($this->request->reveal(), $this->requestHandler->reveal());
    }

    public function testCanAccessWithAllowedIpAddress(): void
    {
        // expect
        $user = new User('testId', 'hashedPassword', ['127.0.0.1']);
        $this->request
            ->getAttribute(AuthUserInterface::class)
            ->willReturn($user);

        $this->request
            ->getServerParams()
            ->willReturn(['REMOTE_ADDR' => '127.0.0.1']);

        $this->request
            ->withAttribute(UserInterface::class, $user)
            ->willReturn($this->request->reveal());

        $this->authentication
            ->unauthorizedResponse($this->request->reveal())
            ->shouldNotHaveBeenCalled();

        $this->requestHandler
            ->handle($this->request->reveal())
            ->shouldBeCalled();

        // given
        $ipAccessControlMiddleware = $this->createIpAccessControlMiddlewareUnderTest();

        // when
        $ipAccessControlMiddleware->process($this->request->reveal(), $this->requestHandler->reveal());
    }
}
