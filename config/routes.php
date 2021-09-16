<?php

declare(strict_types=1);

use Api\Handler\HomePageHandler;
use Mezzio\Application;
use Mezzio\MiddlewareFactory;
use Psr\Container\ContainerInterface;

return static function (
    Application $application,
    MiddlewareFactory $middlewareFactory,
    ContainerInterface $container
): void {
    $application->get('/', HomePageHandler::class, 'home');
};
