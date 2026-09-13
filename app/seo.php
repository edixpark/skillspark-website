<?php

declare(strict_types=1);

// Public identity stays on the official origin, including during local previews.
function canonical_url(string $path = '/'): string
{
    return rtrim(content('site')['url'], '/') . '/' . ltrim($path, '/');
}

function seo_defaults(array $page = []): array
{
    $site = content('site');
    return array_merge([
        'title' => $site['name'] . ' | ' . $site['primary_message'],
        'description' => $site['description'],
        'canonical' => canonical_url(current_path()),
        'image' => canonical_url('/assets/images/branding/skillspark-social-card.png'),
        'type' => 'website',
        'robots' => 'index,follow,max-image-preview:large',
    ], $page);
}

function organization_schema(): array
{
    $site = content('site');
    $schema = [
        '@context' => 'https://schema.org', '@type' => 'Organization',
        '@id' => canonical_url('/#organization'),
        'name' => $site['name'], 'url' => canonical_url('/'),
        'alternateName' => [$site['short_name'], 'Skills Park Tech Hub'],
        'logo' => canonical_url('/assets/images/branding/skillspark-logo.png'),
        'description' => $site['description'], 'foundingDate' => (string) $site['founded'],
    ];
    $email = config('contact.email');
    if ($email) $schema['email'] = $email;
    $telephone = config('contact.phone');
    if ($telephone) {
        $schema['telephone'] = $telephone;
        $schema['contactPoint'] = ['@type' => 'ContactPoint', 'telephone' => $telephone, 'email' => $email, 'contactType' => 'customer service', 'areaServed' => 'NG', 'availableLanguage' => 'English'];
    }
    $schema['address'] = ['@type' => 'PostalAddress', 'streetAddress' => 'Zaria Road', 'addressRegion' => 'Kano State', 'addressCountry' => 'NG'];
    $schema['areaServed'] = [['@type' => 'AdministrativeArea', 'name' => 'Kano State, Nigeria'], ['@type' => 'AdministrativeArea', 'name' => 'Abuja, Federal Capital Territory, Nigeria']];
    $socials = config('contact.socials', []);
    if ($socials) $schema['sameAs'] = array_values(array_unique(array_filter(array_map(static fn (array $social): string => safe_external_url($social['url'] ?? ''), $socials))));
    return $schema;
}

function site_schema(array $seo): array
{
    $organization = organization_schema();
    unset($organization['@context']);
    $publisher = ['@id' => canonical_url('/#organization')];
    $website = [
        '@type' => 'WebSite', '@id' => canonical_url('/#website'),
        'url' => canonical_url('/'), 'name' => content('site')['name'],
        'alternateName' => 'Skills Park Tech Hub', 'publisher' => $publisher,
    ];
    $page = [
        '@type' => 'WebPage', '@id' => $seo['canonical'] . '#webpage',
        'url' => $seo['canonical'], 'name' => $seo['title'],
        'isPartOf' => ['@id' => $website['@id']], 'about' => $publisher, 'publisher' => $publisher,
    ];
    return ['@context' => 'https://schema.org', '@graph' => [$organization, $website, $page]];
}

function breadcrumb_schema(array $items): array
{
    return ['@context' => 'https://schema.org', '@type' => 'BreadcrumbList', 'itemListElement' => array_map(
        static fn ($item, $index) => ['@type' => 'ListItem', 'position' => $index + 1, 'name' => $item['label'], 'item' => canonical_url($item['url'])],
        $items, array_keys($items)
    )];
}
