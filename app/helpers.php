<?php

declare(strict_types=1);

function h(mixed $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function config(?string $key = null, mixed $default = null): mixed
{
    global $config;
    if ($key === null) return $config;
    $value = $config;
    foreach (explode('.', $key) as $segment) {
        if (!is_array($value) || !array_key_exists($segment, $value)) return $default;
        $value = $value[$segment];
    }
    return $value;
}

function content(string $name): array
{
    static $loaded = [];
    if (!isset($loaded[$name])) {
        $file = ROOT_PATH . '/app/content/' . basename($name) . '.php';
        $loaded[$name] = is_file($file) ? (require $file) : [];
    }
    return $loaded[$name];
}

function url(string $path = '/'): string
{
    $base = rtrim((string) config('base_url', ''), '/');
    $path = '/' . ltrim($path, '/');
    return $base . ($path === '/' ? '' : $path);
}

function asset(string $path): string
{
    return url('/assets/' . ltrim($path, '/')) . '?v=' . rawurlencode((string) config('asset_version', '1'));
}

function current_path(): string
{
    $path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
    $path = '/' . trim(rawurldecode($path), '/');
    $basePath = '/' . trim((string) config('base_path', ''), '/');
    if ($basePath !== '/') {
        if ($path === $basePath) $path = '/';
        elseif (str_starts_with($path, $basePath . '/')) $path = substr($path, strlen($basePath)) ?: '/';
    }
    return $path === '' ? '/' : $path;
}

function is_active(string $path): bool
{
    $current = current_path();
    return $path === '/' ? $current === '/' : str_starts_with($current, rtrim($path, '/'));
}

function nav_item_active(array $item): bool
{
    foreach (($item['active_paths'] ?? [$item['url']]) as $path) {
        if (is_active($path)) return true;
    }
    return false;
}

function published(array $items): array
{
    $items = array_filter($items, static fn (array $item): bool => ($item['published'] ?? false) === true);
    usort($items, static fn (array $a, array $b): int => ($a['sort_order'] ?? 999) <=> ($b['sort_order'] ?? 999));
    return array_values($items);
}

function find_by_slug(array $items, string $slug): ?array
{
    foreach (published($items) as $item) if (($item['slug'] ?? '') === $slug) return $item;
    return null;
}

function render(string $view, array $data = [], int $status = 200): never
{
    http_response_code($status);
    $viewFile = ROOT_PATH . '/app/views/' . $view . '.php';
    if (!is_file($viewFile)) throw new RuntimeException('View not found.');
    extract($data, EXTR_SKIP);
    $pageView = $viewFile;
    require ROOT_PATH . '/app/views/layouts/main.php';
    exit;
}

function icon(string $name, string $class = ''): string
{
    $safe = preg_replace('/[^a-z0-9-]/', '', strtolower($name));
    return '<svg class="icon ' . h($class) . '" aria-hidden="true"><use href="' . h(asset('icons/sprite.svg')) . '#' . h($safe) . '"></use></svg>';
}

function excerpt(string $text, int $length = 150): string
{
    $plain = trim(strip_tags($text));
    return mb_strlen($plain) <= $length ? $plain : rtrim(mb_substr($plain, 0, $length - 1)) . '…';
}

function safe_external_url(string $value): string
{
    return filter_var($value, FILTER_VALIDATE_URL) && preg_match('/^https:\/\//i', $value) ? $value : '';
}

function safe_video_embed_url(string $value): string
{
    if (!filter_var($value, FILTER_VALIDATE_URL)) return '';
    $parts = parse_url($value);
    return (($parts['scheme'] ?? '') === 'https' && ($parts['host'] ?? '') === 'www.youtube-nocookie.com' && str_starts_with($parts['path'] ?? '', '/embed/')) ? $value : '';
}

function json_for_html(mixed $value): string
{
    return (string) json_encode($value, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
}

function old(string $key): string
{
    return h($_SESSION['form_old'][$key] ?? '');
}

function flash(string $key, mixed $value = null): mixed
{
    if (func_num_args() === 2) { $_SESSION['flash'][$key] = $value; return null; }
    $result = $_SESSION['flash'][$key] ?? null;
    unset($_SESSION['flash'][$key]);
    return $result;
}

function redirect(string $path): never
{
    header('Location: ' . url($path), true, 303);
    exit;
}

function smtp_ready_for_view(): bool
{
    return (bool) config('smtp.enabled') && config('smtp.host') && config('smtp.username')
        && config('smtp.password') && config('smtp.from_email') && config('smtp.recipient')
        && class_exists(\PHPMailer\PHPMailer\PHPMailer::class);
}
