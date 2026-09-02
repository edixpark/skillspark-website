<?php

declare(strict_types=1);

function configure_session(array $config): void
{
    if (session_status() === PHP_SESSION_ACTIVE) return;
    session_name((string) ($config['session_name'] ?? 'skillspark_session'));
    session_set_cookie_params([
        'lifetime' => 0,
        'path' => '/',
        'secure' => (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off'),
        'httponly' => true,
        'samesite' => 'Lax',
    ]);
    session_start();
}

function send_security_headers(array $config): void
{
    if (headers_sent()) return;
    header('X-Content-Type-Options: nosniff');
    header('Referrer-Policy: strict-origin-when-cross-origin');
    header('Permissions-Policy: camera=(), microphone=(), geolocation=()');
    header('X-Frame-Options: DENY');
    header("Content-Security-Policy: default-src 'self'; img-src 'self' data:; style-src 'self'; script-src 'self'; font-src 'self'; connect-src 'self'; frame-src https://www.youtube-nocookie.com; frame-ancestors 'none'; base-uri 'self'; form-action 'self'");
}

function csrf_token(): string
{
    if (empty($_SESSION['csrf_token'])) $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    return $_SESSION['csrf_token'];
}

function csrf_valid(?string $token): bool
{
    return is_string($token) && isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

function clean_line(mixed $value, int $max = 180): string
{
    $value = trim((string) $value);
    $value = str_replace(["\r", "\n", "\0"], ' ', $value);
    return mb_substr(preg_replace('/\s+/', ' ', $value) ?? '', 0, $max);
}

function clean_text(mixed $value, int $max = 4000): string
{
    $value = trim(strip_tags((string) $value));
    return mb_substr(str_replace("\0", '', $value), 0, $max);
}

function rate_limit_allows(string $form): bool
{
    $now = time();
    $window = (int) config('forms.rate_window', 900);
    $limit = (int) config('forms.rate_limit', 4);
    $key = 'rate_' . preg_replace('/[^a-z]/', '', $form);
    $attempts = array_filter($_SESSION[$key] ?? [], static fn ($stamp): bool => $stamp > $now - $window);
    if (count($attempts) >= $limit) return false;
    $attempts[] = $now;
    $_SESSION[$key] = $attempts;
    return true;
}

function form_started_at(string $form): int
{
    $key = 'started_' . preg_replace('/[^a-z]/', '', $form);
    if (!isset($_SESSION[$key])) $_SESSION[$key] = time();
    return (int) $_SESSION[$key];
}
