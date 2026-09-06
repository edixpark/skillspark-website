<?php

declare(strict_types=1);

return [
    ['label' => 'Services', 'url' => '/services', 'active_paths' => ['/services'], 'wide' => true, 'groups' => [
        ['label' => 'Start here', 'children' => [
            ['label' => 'All Services', 'url' => '/services'],
            ['label' => 'Technology & Software Solutions', 'url' => '/services/technology-and-software'],
            ['label' => 'Web Design & Development', 'url' => '/services/web-design-and-development'],
            ['label' => 'Business Digital Transformation', 'url' => '/services/business-digital-transformation'],
        ]],
        ['label' => 'Creative & technical', 'children' => [
            ['label' => 'Branding & Graphic Design', 'url' => '/services/branding-and-graphic-design'],
            ['label' => 'Video & Media Production', 'url' => '/services/video-and-media-production'],
            ['label' => '3D Modelling & Animation', 'url' => '/services/3d-modelling-and-animation'],
            ['label' => 'Social Media & Digital Presence', 'url' => '/services/social-media-and-digital-presence'],
            ['label' => 'Hardware & Technical Support', 'url' => '/services/hardware-and-technical-support'],
        ]],
    ]],
    ['label' => 'Training', 'url' => '/training', 'active_paths' => ['/training'], 'wide' => true, 'groups' => [
        ['label' => 'Explore training', 'children' => [
            ['label' => 'Training Overview', 'url' => '/training'],
            ['label' => 'Training Programs', 'url' => '/training/programs'],
            ['label' => 'Children & Teenagers', 'url' => '/training/children-and-teenagers'],
            ['label' => 'Students & Graduates', 'url' => '/training/students-and-graduates'],
        ]],
        ['label' => 'Adults & institutions', 'children' => [
            ['label' => 'Adults & Entrepreneurs', 'url' => '/training/adults-and-entrepreneurs'],
            ['label' => 'Schools', 'url' => '/training/schools'],
            ['label' => 'Corporate Training', 'url' => '/training/corporate-training'],
        ]],
    ]],
    ['label' => 'Work & Impact', 'url' => '/work', 'active_paths' => ['/work', '/gallery'], 'groups' => [
        ['label' => 'Evidence & activity', 'children' => [
            ['label' => 'Work & Impact Overview', 'url' => '/work'],
            ['label' => 'Case Studies', 'url' => '/work/case-studies'],
            ['label' => 'Gallery', 'url' => '/gallery'],
            ['label' => 'Achievements & Milestones', 'url' => '/work/achievements'],
            ['label' => 'Partnerships', 'url' => '/work/partnerships'],
        ]],
    ]],
    ['label' => 'EdixPark', 'url' => '/edixpark'],
    ['label' => 'About', 'url' => '/about', 'active_paths' => ['/about', '/founder', '/abuja'], 'groups' => [
        ['label' => 'Company', 'children' => [
            ['label' => 'About SkillsPark', 'url' => '/about'],
            ['label' => 'Founder', 'url' => '/founder'],
            ['label' => 'Serving Abuja', 'url' => '/abuja'],
        ]],
    ]],
];
