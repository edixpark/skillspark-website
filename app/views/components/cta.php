<section class="section cta-band">
    <div class="container cta-band__inner reveal"><div><p class="eyebrow"><?= h($ctaEyebrow ?? 'Start a conversation') ?></p><h2><?= h($ctaTitle ?? 'Let’s identify the right next step.') ?></h2><p><?= h($ctaText ?? 'Tell us what you are trying to improve, build or teach. We will help clarify a practical direction.') ?></p></div><a class="button" href="<?= h(url($ctaUrl ?? '/request-consultation')) ?>"><?= h($ctaLabel ?? 'Request a Consultation') ?></a></div>
</section>
