<?php

declare(strict_types=1);

if (PHP_SAPI !== 'cli' || !extension_loaded('gd')) {
    fwrite(STDERR, "Run this script from the CLI with the GD extension enabled.\n");
    exit(1);
}

$sourceRoot = $argv[1] ?? '';
$projectRoot = dirname(__DIR__);

if ($sourceRoot === '' || !is_dir($sourceRoot)) {
    fwrite(STDERR, "Usage: php -d extension=gd scripts/process-approved-media.php <source-directory>\n");
    exit(1);
}

// This allow-list deliberately excludes IMG_2637.png pending a screen-privacy review.
$jobs = [
    'IMG_2433.png' => [
        'directory' => 'story',
        'name' => 'skillspark-learning-space-wide',
        'ratio' => 16 / 9,
        'widths' => [768, 1200, 1600],
        'focus_x' => 0.5,
        'focus_y' => 0.5,
    ],
    'IMG_0788.png' => [
        'directory' => 'training/young-learners',
        'name' => 'skillspark-young-learners-software-class',
        'ratio' => 4 / 3,
        'widths' => [480, 768, 1200],
        'focus_x' => 0.5,
        'focus_y' => 0.5,
    ],
    'IMG_1170.png' => [
        'directory' => 'training/hardware',
        'name' => 'skillspark-hands-on-hardware-training',
        'ratio' => 4 / 3,
        'widths' => [480, 768, 1200],
        'focus_x' => 0.2,
        'focus_y' => 0.48,
        'crop_scale' => 0.9,
    ],
    'IMG_0947.png' => [
        'directory' => 'training/creative-media',
        'name' => 'skillspark-video-editing-training',
        'ratio' => 4 / 3,
        'widths' => [480, 768, 1200],
        'focus_x' => 0.5,
        'focus_y' => 0.5,
    ],
    'IMG_1236.png' => [
        'directory' => 'training/hardware',
        'name' => 'skillspark-hardware-program-group',
        'ratio' => 4 / 3,
        'widths' => [480, 768, 1200],
        'focus_x' => 0.5,
        'focus_y' => 0.48,
    ],
];

foreach ($jobs as $sourceName => $job) {
    $sourcePath = rtrim($sourceRoot, '/\\') . DIRECTORY_SEPARATOR . $sourceName;
    if (!is_file($sourcePath)) {
        fwrite(STDERR, "Missing approved source: {$sourceName}\n");
        exit(1);
    }

    $source = imagecreatefrompng($sourcePath);
    if ($source === false) {
        fwrite(STDERR, "Unable to decode approved source: {$sourceName}\n");
        exit(1);
    }

    $sourceWidth = imagesx($source);
    $sourceHeight = imagesy($source);
    $sourceRatio = $sourceWidth / $sourceHeight;
    $targetRatio = $job['ratio'];

    if ($sourceRatio > $targetRatio) {
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

    if (($job['crop_scale'] ?? 1) < 1) {
        $scaledWidth = (int) round($cropWidth * $job['crop_scale']);
        $scaledHeight = (int) round($scaledWidth / $targetRatio);
        $cropX += (int) round(($cropWidth - $scaledWidth) * $job['focus_x']);
        $cropY += (int) round(($cropHeight - $scaledHeight) * $job['focus_y']);
        $cropWidth = $scaledWidth;
        $cropHeight = $scaledHeight;
    }

    $outputDirectory = $projectRoot . '/public/assets/images/' . $job['directory'];
    if (!is_dir($outputDirectory) && !mkdir($outputDirectory, 0775, true) && !is_dir($outputDirectory)) {
        fwrite(STDERR, "Unable to create output directory: {$outputDirectory}\n");
        exit(1);
    }

    foreach ($job['widths'] as $width) {
        if ($width > $cropWidth) continue;
        $height = (int) round($width / $targetRatio);
        $canvas = imagecreatetruecolor($width, $height);
        imagecopyresampled($canvas, $source, 0, 0, $cropX, $cropY, $width, $height, $cropWidth, $cropHeight);

        $basePath = $outputDirectory . '/' . $job['name'] . '-' . $width;
        imageinterlace($canvas, true);
        imagejpeg($canvas, $basePath . '.jpg', 82);
        imagewebp($canvas, $basePath . '.webp', 78);
        imagedestroy($canvas);
    }

    imagedestroy($source);
    fwrite(STDOUT, "Processed {$sourceName}\n");
}
