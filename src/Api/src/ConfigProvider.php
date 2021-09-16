<?php

declare(strict_types=1);

namespace Api;

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
            'factories' => [
                Handler\HomePageHandler::class => Factory\HomePageHandlerFactory::class,
            ],
        ];
    }
}
