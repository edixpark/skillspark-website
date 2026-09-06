<?php

declare(strict_types=1);

$config = require dirname(__DIR__) . '/app/bootstrap.php';
$errors = []; $warnings = [];

$required = ['public/index.php','server.php','app/router.php','app/views/layouts/main.php','public/assets/css/site.css','public/assets/js/site.js','public/assets/icons/sprite.svg','README.md','CONTENT_GUIDE.md','DEPLOYMENT.md','SECURITY.md','nginx-skillspark.conf'];
foreach ($required as $file) if (!is_file(ROOT_PATH . '/' . $file)) $errors[] = "Missing required file: {$file}";

$groups = ['services' => content('services'), 'projects' => content('projects'), 'insights' => content('insights'), 'training audiences' => content('training')['audiences'], 'training programs' => content('training')['programs']];
foreach ($groups as $label => $items) {
    $slugs = [];
    foreach ($items as $index => $item) {
        $slug = $item['slug'] ?? '';
        if ($slug === '') $errors[] = "{$label} record {$index} has no slug.";
        if (isset($slugs[$slug])) $errors[] = "Duplicate {$label} slug: {$slug}";
        $slugs[$slug] = true;
        if (($item['published'] ?? false) && isset($item['seo_title']) && trim($item['seo_title']) === '') $errors[] = "Published {$label} '{$slug}' has empty SEO title.";
        if (($item['published'] ?? false) && isset($item['seo_description']) && trim($item['seo_description']) === '') $errors[] = "Published {$label} '{$slug}' has empty SEO description.";
    }
}

$serviceSlugs = array_column(content('services'), 'slug');
foreach (content('projects') as $project) if (($project['related_service'] ?? '') && !in_array($project['related_service'], $serviceSlugs, true)) $errors[] = "Project {$project['slug']} references an unknown service.";

foreach (content('gallery') as $item) {
    if (($item['published'] ?? false) && !($item['consent_confirmed'] ?? false)) $errors[] = "Published gallery item {$item['id']} lacks consent.";
    if (($item['published'] ?? false) && trim($item['alt'] ?? '') === '') $errors[] = "Published gallery item {$item['id']} lacks alt text.";
    if (($item['published'] ?? false) && str_starts_with($item['image'] ?? '', '/assets/')) {
        $file = PUBLIC_PATH . $item['image'];
        if (!is_file($file)) $errors[] = "Gallery asset missing: {$item['image']}";
    }
}

$evidenceStatuses = ['verified', 'needs_details', 'needs_media', 'needs_permission', 'draft'];
$evidenceGroups = [
    'impact stories' => content('impact')['stories'],
    'projects' => content('projects'),
    'achievements' => content('achievements'),
    'partners' => content('partners'),
];
foreach ($evidenceGroups as $label => $items) {
    foreach ($items as $item) {
        $identifier = $item['id'] ?? $item['slug'] ?? 'unknown';
        if (!in_array($item['evidence_status'] ?? '', $evidenceStatuses, true)) {
            $errors[] = "{$label} record '{$identifier}' has an invalid or missing evidence status.";
        }
        if (($item['evidence_status'] ?? '') !== 'verified' && empty($item['verification_needed'])) {
            $errors[] = "{$label} record '{$identifier}' needs a verification checklist.";
        }
    }
}

if (!config('contact.email')) $warnings[] = 'Contact email is not configured.';
if (!config('contact.phone')) $warnings[] = 'Contact phone is not configured.';
if (!config('contact.whatsapp')) $warnings[] = 'WhatsApp number is not configured.';
if (!config('smtp.enabled')) $warnings[] = 'SMTP is disabled; forms will show contact alternatives and cannot submit.';
if (!content('founder')['name']) $warnings[] = 'Founder name and biography still require verification.';

foreach ($warnings as $message) echo "WARNING: {$message}\n";
foreach ($errors as $message) echo "ERROR: {$message}\n";
echo sprintf("Validation complete: %d error(s), %d warning(s).\n", count($errors), count($warnings));
exit($errors ? 1 : 0);
