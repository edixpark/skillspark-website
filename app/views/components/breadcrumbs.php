<?php if (!empty($breadcrumbs)): ?>
<nav class="breadcrumbs" aria-label="Breadcrumb"><ol>
<?php foreach ($breadcrumbs as $index => $crumb): ?><li><?php if ($index < count($breadcrumbs) - 1): ?><a href="<?= h(url($crumb['url'])) ?>"><?= h($crumb['label']) ?></a><?php else: ?><span aria-current="page"><?= h($crumb['label']) ?></span><?php endif; ?></li><?php endforeach; ?>
</ol></nav>
<script type="application/ld+json"><?= json_for_html(breadcrumb_schema($breadcrumbs)) ?></script>
<?php endif; ?>
