<?php

declare(strict_types=1);

// Copy this file to local.php. Never commit real credentials.
return [
    'env' => 'production',
    'debug' => false,
    'base_url' => 'https://skillspark.edixpark.com',
    'contact' => [
        'email' => 'hello@example.com',
        'phone' => '+2340000000000',
        'whatsapp' => '2340000000000',
    ],
    'smtp' => [
        'enabled' => true,
        'host' => 'smtp.example.com',
        'port' => 587,
        'encryption' => 'tls',
        'username' => 'smtp-user',
        'password' => 'replace-me',
        'from_email' => 'website@example.com',
        'from_name' => 'SkillsPark Tech Hub',
        'recipient' => 'enquiries@example.com',
    ],
];
