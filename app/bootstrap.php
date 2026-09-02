<?php

declare(strict_types=1);

define('ROOT_PATH', dirname(__DIR__));
define('PUBLIC_PATH', ROOT_PATH . '/public');

$config = require ROOT_PATH . '/app/config.php';
$localFile = ROOT_PATH . '/config/local.php';
if (is_file($localFile)) {
    $local = require $localFile;
    $config = array_replace_recursive($config, is_array($local) ? $local : []);
}

date_default_timezone_set((string) ($config['timezone'] ?? 'Africa/Lagos'));

ini_set('display_errors', ($config['debug'] ?? false) ? '1' : '0');
ini_set('log_errors', '1');
ini_set('error_log', ROOT_PATH . '/storage/logs/php-error.log');

require ROOT_PATH . '/app/helpers.php';
require ROOT_PATH . '/app/security.php';
require ROOT_PATH . '/app/seo.php';

configure_session($config);
send_security_headers($config);

return $config;
