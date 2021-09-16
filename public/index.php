<?php

declare(strict_types=1);

use Mezzio\Application;
use Mezzio\MiddlewareFactory;
use Psr\Container\ContainerInterface;

if (PHP_SAPI === 'cli-server' && $_SERVER['SCRIPT_FILENAME'] !== __FILE__) {
    return false;
}

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

(static function () {
    /** @var ContainerInterface $container */
    $container = require 'config/container.php';

    /** @var Application $application */
    $application = $container->get(Application::class);
    $middlewareFactory = $container->get(MiddlewareFactory::class);

    (require 'config/pipeline.php')($application, $middlewareFactory, $container);
    (require 'config/routes.php')($application, $middlewareFactory, $container);

    $application->run();
})();
