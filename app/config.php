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
        'email' => 'skillsparktechhub@gmail.com',
        'email_uri' => 'mailto:skillsparktechhub@gmail.com',
        'phone' => '+234 813 949 6905',
        'phone_uri' => 'tel:+2348139496905',
        'whatsapp' => '+234 813 949 6905',
        'whatsapp_url' => 'https://wa.me/2348139496905',
        'locations' => [
            'primary' => 'Zaria Road, Kano State, Nigeria',
            'abuja' => 'Serving Abuja, Federal Capital Territory, Nigeria',
        ],
        'socials' => [
            ['label' => 'Facebook', 'url' => 'https://web.facebook.com/profile.php?id=61566359456187'],
            ['label' => 'Instagram', 'url' => 'https://www.instagram.com/skillsparktechhub/'],
            ['label' => 'X', 'url' => 'https://x.com/skillsparktech'],
            ['label' => 'TikTok', 'url' => 'https://www.tiktok.com/@skillsparktechhub'],
            ['label' => 'LinkedIn', 'url' => 'https://www.linkedin.com/in/skillspark-tech-hub-7b21ab32a/'],
            ['label' => 'SkillsPark Blog', 'url' => 'https://skillsparktechhub.blogspot.com/'],
        ],
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
        'recipient' => 'skillsparktechhub@gmail.com',
    ],
    'forms' => [
        'rate_limit' => 4,
        'rate_window' => 900,
        'minimum_seconds' => 3,
    ],
];
