<?php
$seo = seo_defaults($seo ?? []);
$site = content('site');
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= h($seo['title']) ?></title>
    <meta name="description" content="<?= h($seo['description']) ?>">
    <meta name="robots" content="<?= h($seo['robots']) ?>">
    <link rel="canonical" href="<?= h($seo['canonical']) ?>">
    <meta property="og:type" content="<?= h($seo['type']) ?>">
    <meta property="og:title" content="<?= h($seo['title']) ?>">
    <meta property="og:description" content="<?= h($seo['description']) ?>">
    <meta property="og:url" content="<?= h($seo['canonical']) ?>">
    <meta property="og:image" content="<?= h($seo['image']) ?>">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="theme-color" content="#071a3a">
    <link rel="icon" href="<?= h(asset('brand/favicon.svg')) ?>" type="image/svg+xml">
    <link rel="apple-touch-icon" href="<?= h(asset('brand/apple-touch-icon.svg')) ?>">
    <link rel="manifest" href="<?= h(url('/site.webmanifest')) ?>">
    <link rel="stylesheet" href="<?= h(asset('css/site.css')) ?>">
    <script type="application/ld+json"><?= json_for_html(organization_schema()) ?></script>
</head>
<body>
<a class="skip-link" href="#main-content">Skip to content</a>
<?php require ROOT_PATH . '/app/views/components/header.php'; ?>
<main id="main-content" tabindex="-1">
    <?php require $pageView; ?>
</main>
<?php require ROOT_PATH . '/app/views/components/footer.php'; ?>
<script src="<?= h(asset('js/site.js')) ?>" defer></script>
</body>
</html>
