<?php

declare(strict_types=1);

return [
    ['label' => 'Home', 'url' => '/'],
    ['label' => 'About', 'url' => '/about'],
    ['label' => 'Services', 'url' => '/services', 'children' => [
        ['label' => 'Technology & software', 'url' => '/services/technology-and-software'],
        ['label' => 'Web design & development', 'url' => '/services/web-design-and-development'],
        ['label' => 'Digital transformation', 'url' => '/services/business-digital-transformation'],
        ['label' => 'Branding & design', 'url' => '/services/branding-and-graphic-design'],
        ['label' => 'View all services', 'url' => '/services'],
    ]],
    ['label' => 'Training', 'url' => '/training', 'children' => [
        ['label' => 'Programs', 'url' => '/training/programs'],
        ['label' => 'Children & teenagers', 'url' => '/training/children-and-teenagers'],
        ['label' => 'Students & graduates', 'url' => '/training/students-and-graduates'],
        ['label' => 'Adults & entrepreneurs', 'url' => '/training/adults-and-entrepreneurs'],
        ['label' => 'Schools', 'url' => '/training/schools'],
        ['label' => 'Corporate training', 'url' => '/training/corporate-training'],
    ]],
    ['label' => 'Work & Impact', 'url' => '/work', 'children' => [
        ['label' => 'Case studies', 'url' => '/work/case-studies'],
        ['label' => 'Achievements', 'url' => '/work/achievements'],
        ['label' => 'Partnerships', 'url' => '/work/partnerships'],
        ['label' => 'Gallery', 'url' => '/gallery'],
    ]],
    ['label' => 'EdixPark', 'url' => '/edixpark'],
    ['label' => 'Founder', 'url' => '/founder'],
    ['label' => 'Contact', 'url' => '/contact'],
];
