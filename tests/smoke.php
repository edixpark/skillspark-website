<?php

declare(strict_types=1);

$base = rtrim($argv[1] ?? 'http://127.0.0.1:8000', '/');
$routes = ['/', '/about', '/services', '/training', '/training/programs', '/work', '/gallery', '/edixpark', '/founder', '/insights', '/contact', '/request-consultation', '/privacy-policy', '/terms', '/abuja', '/work/case-studies', '/work/achievements', '/work/partnerships', '/solutions/schools', '/solutions/businesses', '/solutions/organizations', '/solutions/individuals', '/services/technology-and-software', '/services/web-design-and-development', '/services/business-digital-transformation', '/services/branding-and-graphic-design', '/services/video-and-media-production', '/services/3d-modelling-and-animation', '/services/social-media-and-digital-presence', '/services/hardware-and-technical-support', '/training/children-and-teenagers', '/training/students-and-graduates', '/training/adults-and-entrepreneurs', '/training/schools', '/training/corporate-training', '/training/program/web-development-foundations', '/training/program/creative-design', '/training/program/robotics-creative-technology', '/training/program/ai-digital-productivity', '/training/program/computer-hardware-repairs', '/work/case-studies/practical-software-classes', '/work/case-studies/hands-on-hardware-classes', '/insights/what-makes-technology-training-practical', '/insights/digital-presence-check', '/insights/children-technology-responsibly', '/sitemap.xml', '/robots.txt'];
$failures = []; $htmlPages = [];
$titles = [];

function request_url(string $url, string $method = 'GET', string $body = '', array $headers = []): array {
    $options = ['http' => ['method' => $method, 'ignore_errors' => true, 'timeout' => 8, 'header' => implode("\r\n", $headers), 'content' => $body]];
    $content = @file_get_contents($url, false, stream_context_create($options));
    $responseHeaders = $http_response_header ?? [];
    preg_match('/\s(\d{3})\s/', $responseHeaders[0] ?? '', $match);
    return [(int) ($match[1] ?? 0), $content === false ? '' : $content, $responseHeaders];
}

foreach ($routes as $route) {
    [$status, $body, $responseHeaders] = request_url($base . $route);
    if ($status !== 200) $failures[] = "{$route} returned {$status}";
    if ($body === '') $failures[] = "{$route} returned an empty response";
    if (str_contains($body, '<html')) {
        $htmlPages[$route] = $body;
        preg_match('/<title>(.*?)<\/title>/s', $body, $titleMatch);
        $pageTitle = html_entity_decode(trim($titleMatch[1] ?? ''));
        if ($pageTitle === '') $failures[] = "{$route} has no page title.";
        if (isset($titles[$pageTitle])) $failures[] = "Duplicate page title on {$route} and {$titles[$pageTitle]}: {$pageTitle}";
        $titles[$pageTitle] = $route;
        if (!preg_match('/<meta name="description" content="[^"]+">/', $body)) $failures[] = "{$route} has no meta description.";
        if (!str_contains($body, '<h1')) $failures[] = "{$route} has no H1.";
    }
    echo sprintf("%3d %s\n", $status, $route);
}

[, $homeBody, $homeHeaders] = request_url($base . '/');
$headerText = strtolower(implode("\n", $homeHeaders));
foreach (['content-security-policy:', 'x-content-type-options:', 'referrer-policy:', 'permissions-policy:', 'x-frame-options:'] as $requiredHeader) if (!str_contains($headerText, $requiredHeader)) $failures[] = "Security header missing: {$requiredHeader}";
[, $sitemapBody] = request_url($base . '/sitemap.xml');
$xml = new DOMDocument();
if (!@$xml->loadXML($sitemapBody) || $xml->documentElement?->localName !== 'urlset') $failures[] = 'Sitemap XML is invalid.';
if (str_contains($htmlPages['/gallery'] ?? '', 'Internal permission')) $failures[] = 'Private gallery permission notes leaked into public HTML.';

[$notFoundStatus] = request_url($base . '/definitely-not-a-route');
if ($notFoundStatus !== 404) $failures[] = "404 route returned {$notFoundStatus}";
echo sprintf("%3d %s\n", $notFoundStatus, '/definitely-not-a-route');

$internalLinks = [];
foreach ($htmlPages as $route => $html) {
    if (!preg_match_all('/(?:href|src)="([^"]+)"/', $html, $matches)) continue;
    foreach (array_unique($matches[1]) as $link) {
        $decoded = html_entity_decode($link);
        $path = parse_url($decoded, PHP_URL_PATH);
        $host = parse_url($decoded, PHP_URL_HOST);
        if (!$path || ($host && !str_contains($base, $host))) continue;
        $internalLinks[$path] = $route;
    }
}
foreach ($internalLinks as $path => $source) {
    [$linkedStatus] = request_url($base . $path);
    if ($linkedStatus !== 200) $failures[] = "Internal link {$path} from {$source} returned {$linkedStatus}";
}

[$postStatus, , $postHeaders] = request_url($base . '/contact', 'POST', 'name=Bot&email=bot%40example.com', ['Content-Type: application/x-www-form-urlencoded']);
if (!in_array($postStatus, [302, 303], true)) $failures[] = "CSRF rejection did not redirect safely (status {$postStatus}).";

echo $failures ? "\nFAILURES\n- " . implode("\n- ", array_unique($failures)) . "\n" : "\nSmoke tests passed.\n";
exit($failures ? 1 : 0);
