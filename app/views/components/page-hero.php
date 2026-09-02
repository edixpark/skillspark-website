<section class="page-hero <?= h($heroClass ?? '') ?>">
    <div class="container">
        <?php if (!empty($breadcrumbs)) require ROOT_PATH . '/app/views/components/breadcrumbs.php'; ?>
        <?php if (!empty($eyebrow)): ?><p class="eyebrow"><?= h($eyebrow) ?></p><?php endif; ?>
        <h1><?= h($title) ?></h1>
        <?php if (!empty($intro)): ?><p class="lead"><?= h($intro) ?></p><?php endif; ?>
        <?php if (!empty($heroActions)): ?><div class="button-row"><?php foreach ($heroActions as $index => $action): ?><a class="button <?= $index ? 'button--outline-light' : '' ?>" href="<?= h(url($action['url'])) ?>"><?= h($action['label']) ?></a><?php endforeach; ?></div><?php endif; ?>
    </div>
</section>
