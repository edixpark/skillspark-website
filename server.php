<?php

declare(strict_types=1);

$path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
$public = realpath(__DIR__ . '/public');
$candidate = realpath(__DIR__ . '/public' . $path);
if ($path !== '/' && $public && $candidate && str_starts_with($candidate, $public . DIRECTORY_SEPARATOR) && is_file($candidate)) {
    $types = ['css'=>'text/css; charset=UTF-8','js'=>'application/javascript; charset=UTF-8','svg'=>'image/svg+xml','png'=>'image/png','jpg'=>'image/jpeg','jpeg'=>'image/jpeg','webp'=>'image/webp','avif'=>'image/avif','ico'=>'image/x-icon','json'=>'application/manifest+json','txt'=>'text/plain; charset=UTF-8','xml'=>'application/xml; charset=UTF-8'];
    $extension = strtolower(pathinfo($candidate, PATHINFO_EXTENSION));
    header('Content-Type: ' . ($types[$extension] ?? 'application/octet-stream'));
    header('Content-Length: ' . filesize($candidate));
    readfile($candidate);
    return;
}
require __DIR__ . '/public/index.php';
