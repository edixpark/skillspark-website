<article class="card program-card reveal">
    <p class="kicker"><?= h($item['audience'] ?? 'Practical training') ?></p>
    <h3><a href="<?= h(url('/training/program/' . $item['slug'])) ?>"><?= h($item['title']) ?></a></h3>
    <p><?= h($item['summary']) ?></p>
    <a class="text-link" href="<?= h(url('/training/program/' . $item['slug'])) ?>">View program <?= icon('arrow') ?></a>
</article>
