<?php

declare(strict_types=1);

$config = require dirname(__DIR__) . '/app/bootstrap.php';
require ROOT_PATH . '/app/router.php';
ob_start();
output_sitemap();
$xml = ob_get_clean();
$target = ROOT_PATH . '/public/sitemap.xml';
if (file_put_contents($target, $xml) === false) {
    fwrite(STDERR, "Could not write {$target}\n");
    exit(1);
}
echo "Generated {$target}\n";
