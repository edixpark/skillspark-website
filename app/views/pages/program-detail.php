<?php
$title = $program['title'];
$eyebrow = $program['eyebrow'] ?? 'SkillsPark program';
$intro = $program['summary'];
$breadcrumbs = [['label' => 'Home', 'url' => '/'], ['label' => 'Training', 'url' => '/training'], ['label' => 'Programs', 'url' => '/training/programs'], ['label' => $program['title'], 'url' => '/training/program/' . $program['slug']]];
$heroActions = [['label' => 'Ask About This Program', 'url' => '/contact'], ['label' => 'View All Programs', 'url' => '/training/programs']];
require ROOT_PATH . '/app/views/components/page-hero.php';
$isCourseDetail = ($program['slug'] ?? '') === 'computer-hardware-repairs';
?>
<?php if (!empty($program['image'])): ?>
<section class="section training-evidence-section">
    <div class="container story-block__grid">
        <picture class="training-story-media reveal">
            <source type="image/webp" srcset="<?= h(asset($program['image'] . '-480.webp')) ?> 480w, <?= h(asset($program['image'] . '-768.webp')) ?> 768w, <?= h(asset($program['image'] . '-1200.webp')) ?> 1200w" sizes="(max-width: 860px) calc(100vw - 32px), 50vw">
            <img src="<?= h(asset($program['image'] . '-768.jpg')) ?>" srcset="<?= h(asset($program['image'] . '-480.jpg')) ?> 480w, <?= h(asset($program['image'] . '-768.jpg')) ?> 768w, <?= h(asset($program['image'] . '-1200.jpg')) ?> 1200w" sizes="(max-width: 860px) calc(100vw - 32px), 50vw" width="<?= h($program['image_width'] ?? 1200) ?>" height="<?= h($program['image_height'] ?? 675) ?>" loading="lazy" alt="<?= h($program['image_alt'] ?? $program['title']) ?>">
        </picture>
        <div class="reveal">
            <p class="eyebrow"><?= h($isCourseDetail ? 'Course evidence' : 'Program focus') ?></p>
            <h2><?= h($program['summary']) ?></h2>
            <p><?= h($program['body'] ?? $program['summary']) ?></p>
        </div>
    </div>
</section>
<?php else: ?>
<section class="section">
    <div class="container narrow">
        <p class="eyebrow">Program focus</p>
        <h2><?= h($program['summary']) ?></h2>
        <p class="standfirst"><?= h($program['body'] ?? $program['summary']) ?></p>
    </div>
</section>
<?php endif; ?>
<?php if ($program['slug'] === 'computer-hardware-repairs'): ?><section class="section training-evidence-section"><div class="container story-block__grid"><div class="reveal"><p class="eyebrow">HANDS-ON HARDWARE</p><h2>Understanding the computer from the inside out.</h2><p>SkillsPark hardware training introduces learners to the components that make a computer work and develops practical ability in diagnosis, troubleshooting and maintenance. Learners work directly with hardware so they can understand common faults, investigate likely causes and practise appropriate repair and maintenance techniques.</p></div><div class="editorial-media-grid editorial-media-grid--duo reveal"><picture class="editorial-media editorial-media--large"><source type="image/webp" srcset="<?= h(asset('images/training/computer-hardware/computer-hardware-training-group-480.webp')) ?> 480w, <?= h(asset('images/training/computer-hardware/computer-hardware-training-group-768.webp')) ?> 768w, <?= h(asset('images/training/computer-hardware/computer-hardware-training-group-1200.webp')) ?> 1200w" sizes="(max-width: 860px) calc(100vw - 32px), 34vw"><img src="<?= h(asset('images/training/computer-hardware/computer-hardware-training-group-768.jpg')) ?>" srcset="<?= h(asset('images/training/computer-hardware/computer-hardware-training-group-480.jpg')) ?> 480w, <?= h(asset('images/training/computer-hardware/computer-hardware-training-group-768.jpg')) ?> 768w, <?= h(asset('images/training/computer-hardware/computer-hardware-training-group-1200.jpg')) ?> 1200w" sizes="(max-width: 860px) calc(100vw - 32px), 34vw" width="1200" height="900" loading="lazy" alt="SkillsPark learners in a hands-on computer hardware training session."></picture><picture class="editorial-media"><source type="image/webp" srcset="<?= h(asset('images/training/computer-hardware/computer-maintenance-practical-480.webp')) ?> 480w, <?= h(asset('images/training/computer-hardware/computer-maintenance-practical-768.webp')) ?> 768w, <?= h(asset('images/training/computer-hardware/computer-maintenance-practical-1200.webp')) ?> 1200w" sizes="(max-width: 860px) calc((100vw - 44px) / 2), 18vw"><img src="<?= h(asset('images/training/computer-hardware/computer-maintenance-practical-480.jpg')) ?>" srcset="<?= h(asset('images/training/computer-hardware/computer-maintenance-practical-480.jpg')) ?> 480w, <?= h(asset('images/training/computer-hardware/computer-maintenance-practical-768.jpg')) ?> 768w, <?= h(asset('images/training/computer-hardware/computer-maintenance-practical-1200.jpg')) ?> 1200w" sizes="(max-width: 860px) calc((100vw - 44px) / 2), 18vw" width="1200" height="900" loading="lazy" alt="A SkillsPark learner practising computer maintenance and troubleshooting."></picture></div></div></section><?php endif; ?>
<section class="section section--soft">
    <div class="container detail-grid">
        <div>
            <p class="eyebrow">Who it is for</p>
            <h2><?= h($program['audience']) ?></h2>
            <?php if (!empty($program['approach'])): ?><p><?= h($program['approach']) ?></p><?php endif; ?>
            <p>Entry requirements, delivery format, duration, current pricing and location are confirmed for each cohort or engagement.</p>
        </div>
        <div>
            <p class="eyebrow"><?= h($isCourseDetail ? 'What learners practise' : 'Course areas included') ?></p>
            <ul class="feature-list"><?php foreach ($program['skills'] as $skill): ?><li><?= icon('check') ?><span><?= h($skill) ?></span></li><?php endforeach; ?></ul>
        </div>
    </div>
</section>
<?php if (!empty($program['related_audiences'])): ?>
<section class="section">
    <div class="container">
        <div class="section-heading"><p class="eyebrow">Related audiences</p><h2>Where this pathway often fits.</h2></div>
        <div class="training-chip-list"><?php foreach ($program['related_audiences'] as $audience): ?><span><?= h($audience) ?></span><?php endforeach; ?></div>
    </div>
</section>
<?php endif; ?>
<?php $relatedPrograms = array_values(array_filter(published(content('training')['programs']), static fn ($item) => ($item['slug'] !== $program['slug']) && (($item['featured'] ?? false) === true))); ?>
<section class="section section--soft"><div class="container"><div class="section-heading"><p class="eyebrow">Continue exploring</p><h2>More practical learning pathways.</h2></div><div class="card-grid card-grid--3"><?php foreach(array_slice($relatedPrograms, 0, 3) as $item) require ROOT_PATH . '/app/views/components/program-card.php'; ?></div></div></section>
<?php $ctaTitle = 'Ask about ' . $program['title'] . '.'; $ctaText = 'Share the learner profile and preferred delivery context. We will respond with the practical next step.'; $ctaLabel = 'Ask About Training'; $ctaUrl = '/contact'; require ROOT_PATH . '/app/views/components/cta.php'; ?>
