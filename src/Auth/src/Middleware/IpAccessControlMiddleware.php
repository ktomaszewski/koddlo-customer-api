<?php

declare(strict_types=1);

namespace Auth\Middleware;

use Auth\Model\Interface\UserInterface;
use Mezzio\Authentication\AuthenticationInterface;
use Mezzio\Authentication\UserInterface as AuthUserInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Webmozart\Assert\Assert;
use function in_array;

final class IpAccessControlMiddleware implements MiddlewareInterface
{
    public function __construct(private AuthenticationInterface $authentication)
    {
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        /** @var UserInterface $user */
        $user = $request->getAttribute(AuthUserInterface::class);
        Assert::isInstanceOf($user, UserInterface::class);

        $requestIpAddress = $request->getServerParams()['REMOTE_ADDR'];
        if (!in_array($requestIpAddress, $user->getIpAddresses(), true)) {
            return $this->authentication->unauthorizedResponse($request);
        }

        return $handler->handle(
            $request->withAttribute(UserInterface::class, $user)
        );
    }
}
