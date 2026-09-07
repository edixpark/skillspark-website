<?php

declare(strict_types=1);

if (PHP_SAPI !== 'cli' || !extension_loaded('gd')) {
    fwrite(STDERR, "Run this script from the CLI with the GD extension enabled.\n");
    exit(1);
}

$sourceRoot = $argv[1] ?? '';
$projectRoot = dirname(__DIR__);

if ($sourceRoot === '' || !is_dir($sourceRoot)) {
    fwrite(STDERR, "Usage: php -d extension=gd scripts/process-strengthen-media.php <source-directory>\n");
    exit(1);
}

$jobs = [
    'advista_hub.png' => ['directory' => 'impact/advista-hub', 'name' => 'skillspark-advista-hub-learner-outcome', 'ratio' => 4 / 3, 'widths' => [480, 768, 1200], 'focus_x' => .5, 'focus_y' => .58],
    'Female freelancers.png' => ['directory' => 'impact/women-hardware', 'name' => 'skillspark-women-hardware-training', 'ratio' => 4 / 3, 'widths' => [480, 768, 1200], 'focus_x' => .5, 'focus_y' => .63],
    'SIWES.png' => ['directory' => 'impact/siwes', 'name' => 'skillspark-siwes-practical-learning', 'ratio' => 16 / 9, 'widths' => [480, 768, 1200], 'focus_x' => .5, 'focus_y' => .5],
    'aptech_computer_education_logo.jpg' => ['directory' => 'partners/aptech', 'name' => 'aptech-computer-training-logo', 'ratio' => 1, 'widths' => [200], 'focus_x' => .5, 'focus_y' => .5],
];

foreach ($jobs as $sourceName => $job) {
    $sourcePath = rtrim($sourceRoot, '/\\') . DIRECTORY_SEPARATOR . $sourceName;
    if (!is_file($sourcePath)) {
        fwrite(STDERR, "Missing approved source: {$sourceName}\n");
        exit(1);
    }

    $extension = strtolower(pathinfo($sourcePath, PATHINFO_EXTENSION));
    $source = $extension === 'png' ? imagecreatefrompng($sourcePath) : imagecreatefromjpeg($sourcePath);
    if ($source === false) {
        fwrite(STDERR, "Unable to decode approved source: {$sourceName}\n");
        exit(1);
    }

    $sourceWidth = imagesx($source);
    $sourceHeight = imagesy($source);
    $targetRatio = $job['ratio'];
    if ($sourceWidth / $sourceHeight > $targetRatio) {
        $cropHeight = $sourceHeight;
        $cropWidth = (int) round($cropHeight * $targetRatio);
        $cropX = (int) round(($sourceWidth - $cropWidth) * $job['focus_x']);
        $cropY = 0;
    } else {
        $cropWidth = $sourceWidth;
        $cropHeight = (int) round($cropWidth / $targetRatio);
        $cropX = 0;
        $cropY = (int) round(($sourceHeight - $cropHeight) * $job['focus_y']);
    }

    $outputDirectory = $projectRoot . '/public/assets/images/' . $job['directory'];
    if (!is_dir($outputDirectory) && !mkdir($outputDirectory, 0775, true) && !is_dir($outputDirectory)) {
        fwrite(STDERR, "Unable to create output directory: {$outputDirectory}\n");
        exit(1);
    }

    foreach ($job['widths'] as $width) {
        $outputWidth = min($width, $cropWidth);
        $height = (int) round($outputWidth / $targetRatio);
        $canvas = imagecreatetruecolor($outputWidth, $height);
        imagecopyresampled($canvas, $source, 0, 0, $cropX, $cropY, $outputWidth, $height, $cropWidth, $cropHeight);
        imageinterlace($canvas, true);
        $basePath = $outputDirectory . '/' . $job['name'] . '-' . $outputWidth;
        imagejpeg($canvas, $basePath . '.jpg', 82);
        imagewebp($canvas, $basePath . '.webp', 78);
        imagedestroy($canvas);
    }
    imagedestroy($source);
    fwrite(STDOUT, "Processed {$sourceName}\n");
}
