<article class="card service-card reveal">
    <div class="icon-box"><?= icon($item['icon'] ?? 'spark') ?></div>
    <h3><a href="<?= h(url('/services/' . $item['slug'])) ?>"><?= h($item['title']) ?></a></h3>
    <p><?= h($item['summary']) ?></p>
    <a class="text-link" href="<?= h(url('/services/' . $item['slug'])) ?>">Explore service <?= icon('arrow') ?></a>
</article>
