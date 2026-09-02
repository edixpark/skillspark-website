<?php

declare(strict_types=1);

function seo_defaults(array $page = []): array
{
    $site = content('site');
    return array_merge([
        'title' => $site['name'] . ' | ' . $site['primary_message'],
        'description' => $site['description'],
        'canonical' => url(current_path()),
        'image' => asset('brand/social-card.svg'),
        'type' => 'website',
        'robots' => 'index,follow,max-image-preview:large',
    ], $page);
}

function organization_schema(): array
{
    $site = content('site');
    $schema = [
        '@context' => 'https://schema.org', '@type' => 'Organization',
        'name' => $site['name'], 'url' => url('/'),
        'logo' => asset('brand/skillspark-wordmark.svg'),
        'description' => $site['description'], 'foundingDate' => '2024',
    ];
    $email = config('contact.email');
    if ($email) $schema['email'] = $email;
    return $schema;
}

function breadcrumb_schema(array $items): array
{
    return ['@context' => 'https://schema.org', '@type' => 'BreadcrumbList', 'itemListElement' => array_map(
        static fn ($item, $index) => ['@type' => 'ListItem', 'position' => $index + 1, 'name' => $item['label'], 'item' => url($item['url'])],
        $items, array_keys($items)
    )];
}
