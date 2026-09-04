<?php

declare(strict_types=1);

return [
    'env' => 'production',
    'debug' => false,
    'base_url' => 'https://skillspark.edixpark.com',
    'base_path' => '',
    'timezone' => 'Africa/Lagos',
    'session_name' => 'skillspark_session',
    'asset_version' => '1.0.0',
    'contact' => [
        'email' => '',
        'phone' => '',
        'whatsapp' => '',
        'hours' => 'Monday–Friday, 9:00–17:00 WAT',
        'locations' => ['Kano/Zaria Road area', 'Serving Abuja'],
    ],
    'smtp' => [
        'enabled' => false,
        'host' => '',
        'port' => 587,
        'encryption' => 'tls',
        'username' => '',
        'password' => '',
        'from_email' => '',
        'from_name' => 'SkillsPark Tech Hub',
        'recipient' => '',
    ],
    'forms' => [
        'rate_limit' => 4,
        'rate_window' => 900,
        'minimum_seconds' => 3,
    ],
];
