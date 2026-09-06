<?php
$title = 'Work, learning and impact—documented responsibly.';
$eyebrow = 'Work & Impact';
$intro = 'A public record of practical training, learner progress, community learning, partnerships and technology work—limited to what SkillsPark can state responsibly.';
$breadcrumbs = [['label' => 'Home', 'url' => '/'], ['label' => 'Work & Impact', 'url' => '/work']];
require ROOT_PATH . '/app/views/components/page-hero.php';
$impact = content('impact');
$areas = published($impact['areas']);
$stories = published($impact['stories']);
?>

<section class="section">
    <div class="container">
        <div class="section-heading reveal">
            <p class="eyebrow">Impact areas</p>
            <h2>What SkillsPark has actually contributed.</h2>
            <p>These areas describe documented activity and owner-verified outcomes. They do not imply unsupported scale, income, accreditation or client results.</p>
        </div>
        <div class="card-grid card-grid--3">
            <?php foreach ($areas as $area): ?>
                <article class="card reveal">
                    <span class="icon-box"><?= icon($area['icon']) ?></span>
                    <h3><?= h($area['title']) ?></h3>
                    <p><?= h($area['summary']) ?></p>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="section section--soft">
    <div class="container">
        <div class="section-heading reveal">
            <p class="eyebrow">Featured evidence</p>
            <h2>Specific activities and outcomes.</h2>
        </div>
        <div class="case-list">
            <?php foreach ($stories as $story): ?>
                <article class="case-row reveal">
                    <div>
                        <span class="tag"><?= h($story['category']) ?></span>
                        <h3><a href="<?= h(url($story['url'])) ?>"><?= h($story['title']) ?></a></h3>
                        <p><?= h($story['summary']) ?></p>
                    </div>
                    <a class="circle-link" href="<?= h(url($story['url'])) ?>" aria-label="Explore <?= h($story['title']) ?>"><?= icon('arrow') ?></a>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="section">
    <div class="container story-block__grid">
        <div class="story-art reveal">
            <picture>
                <source type="image/webp" srcset="<?= h(asset('images/training/hardware/skillspark-hands-on-hardware-training-480.webp')) ?> 480w, <?= h(asset('images/training/hardware/skillspark-hands-on-hardware-training-768.webp')) ?> 768w, <?= h(asset('images/training/hardware/skillspark-hands-on-hardware-training-1200.webp')) ?> 1200w" sizes="(max-width: 860px) calc(100vw - 32px), 50vw">
                <img src="<?= h(asset('images/training/hardware/skillspark-hands-on-hardware-training-768.jpg')) ?>" srcset="<?= h(asset('images/training/hardware/skillspark-hands-on-hardware-training-480.jpg')) ?> 480w, <?= h(asset('images/training/hardware/skillspark-hands-on-hardware-training-768.jpg')) ?> 768w, <?= h(asset('images/training/hardware/skillspark-hands-on-hardware-training-1200.jpg')) ?> 1200w" sizes="(max-width: 860px) calc(100vw - 32px), 50vw" width="1200" height="900" loading="lazy" alt="Participants working on an open desktop computer during SkillsPark hardware training.">
            </picture>
        </div>
        <div class="reveal">
            <p class="eyebrow">SIWES & practical learning</p>
            <h2>Experience grows through supervised practice.</h2>
            <p>SkillsPark has trained SIWES students and provided hands-on technology exposure. Institution names, placement dates and duration remain unpublished until those details are confirmed.</p>
            <a class="text-link" href="<?= h(url('/training/students-and-graduates')) ?>">Explore student training <?= icon('arrow') ?></a>
        </div>
    </div>
</section>

<section class="section section--navy">
    <div class="container two-col">
        <article class="card">
            <p class="eyebrow">Community learning</p>
            <h2>Useful learning beyond paid programmes.</h2>
            <p>SkillsPark has provided free classes, practical workshops and free online tutorials to make technology learning more accessible.</p>
            <a class="text-link" href="<?= h(url('/insights')) ?>">Explore insights and tutorials <?= icon('arrow') ?></a>
        </article>
        <article class="card">
            <p class="eyebrow">Technology work</p>
            <h2>Support for organizations building digital solutions.</h2>
            <p>SkillsPark supports organizations with the design and development of technology products and digital solutions. Client and project identities remain private until publication permission is confirmed.</p>
            <a class="text-link" href="<?= h(url('/services/technology-and-software')) ?>">Explore technology services <?= icon('arrow') ?></a>
        </article>
    </div>
</section>

<section class="section section--soft">
    <div class="container work-links">
        <a href="<?= h(url('/work/case-studies')) ?>"><span>Case studies</span><strong>Objectives, approaches and outcomes supported by available evidence.</strong><?= icon('arrow') ?></a>
        <a href="<?= h(url('/gallery')) ?>"><span>Gallery</span><strong>Approved photographs of practical learning and activity.</strong><?= icon('arrow') ?></a>
        <a href="<?= h(url('/work/partnerships')) ?>"><span>Partnerships</span><strong>Collaboration described only to the level currently verified.</strong><?= icon('arrow') ?></a>
    </div>
</section>

<?php
$ctaTitle = 'Discuss a project, training need or partnership.';
$ctaText = 'Tell us the context and the outcome you are working toward. We will help define a practical next step.';
require ROOT_PATH . '/app/views/components/cta.php';
?>
