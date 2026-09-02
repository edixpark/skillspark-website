<?php

declare(strict_types=1);

try {
    $config = require dirname(__DIR__) . '/app/bootstrap.php';
    $autoload = dirname(__DIR__) . '/vendor/autoload.php';
    if (is_file($autoload)) require $autoload;
    require dirname(__DIR__) . '/app/router.php';
    route_request($_SERVER['REQUEST_METHOD'] ?? 'GET', current_path());
} catch (Throwable $exception) {
    error_log('Unhandled application error at ' . gmdate('c') . '; type=' . get_class($exception));
    if (!headers_sent()) http_response_code(500);
    $seo = function_exists('seo_defaults') ? seo_defaults(['title' => 'Temporary problem | SkillsPark', 'robots' => 'noindex,nofollow']) : ['title' => 'Temporary problem', 'description' => '', 'canonical' => '', 'image' => '', 'type' => 'website', 'robots' => 'noindex,nofollow'];
    $pageView = dirname(__DIR__) . '/app/views/errors/500.php';
    if (is_file(dirname(__DIR__) . '/app/views/layouts/main.php')) require dirname(__DIR__) . '/app/views/layouts/main.php';
    else echo 'The website is temporarily unavailable.';
}
