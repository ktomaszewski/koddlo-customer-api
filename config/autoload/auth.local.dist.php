<?php

declare(strict_types=1);

return [
    'authentication' => [
        'users' => [
            ':username' => [
                'password'    => ':password',
                'ipAddresses' => [
                    ':ipAddress1',
                    ':ipAddress2',
                ],
            ],
        ],
    ],
];
