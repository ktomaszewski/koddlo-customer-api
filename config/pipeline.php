<?php

declare(strict_types=1);

use Laminas\Stratigility\Middleware\ErrorHandler;
use Mezzio\Application;
use Mezzio\Handler\NotFoundHandler;
use Mezzio\Helper\ServerUrlMiddleware;
use Mezzio\Helper\UrlHelperMiddleware;
use Mezzio\MiddlewareFactory;
use Mezzio\Router\Middleware\DispatchMiddleware;
use Mezzio\Router\Middleware\ImplicitHeadMiddleware;
use Mezzio\Router\Middleware\ImplicitOptionsMiddleware;
use Mezzio\Router\Middleware\MethodNotAllowedMiddleware;
use Mezzio\Router\Middleware\RouteMiddleware;
use Psr\Container\ContainerInterface;

return static function (Application $application, MiddlewareFactory $middlewareFactory, ContainerInterface $container): void {
    $application->pipe(ErrorHandler::class);

    $application->pipe(ServerUrlMiddleware::class);
    $application->pipe(RouteMiddleware::class);

    $application->pipe(ImplicitHeadMiddleware::class);
    $application->pipe(ImplicitOptionsMiddleware::class);
    $application->pipe(MethodNotAllowedMiddleware::class);

    $application->pipe(UrlHelperMiddleware::class);

    $application->pipe(DispatchMiddleware::class);

    $application->pipe(NotFoundHandler::class);
};
