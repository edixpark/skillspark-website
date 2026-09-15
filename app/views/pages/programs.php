<?php
$training = content('training');
$programs = array_values(array_filter(published($training['programs']), static fn (array $item): bool => ($item['featured'] ?? false) === true));
$catalogue = $training['course_catalogue'] ?? [];
$title = 'Choose how you want to learn.';
$eyebrow = 'SkillsPark Training Programs';
$intro = 'Whether you are starting with broad digital foundations, specializing in one field, developing technical capability, growing a business, preparing to teach others or looking for personalized instruction, SkillsPark provides practical learning pathways designed around different goals.';
$breadcrumbs = [['label' => 'Home', 'url' => '/'], ['label' => 'Training', 'url' => '/training'], ['label' => 'Programs', 'url' => '/training/programs']];
require ROOT_PATH . '/app/views/components/page-hero.php';
?>
<section class="section">
    <div class="container">
        <div class="section-heading">
            <p class="eyebrow">Goal-based pathways</p>
            <h2>Start with the kind of learning you need.</h2>
            <p>Programs are learning pathways. Courses are the subjects or skills taught inside those pathways.</p>
        </div>
        <div class="program-selector-grid">
            <?php foreach ($programs as $item): ?>
                <article class="program-selector-card reveal">
                    <p class="kicker"><?= h($item['eyebrow'] ?? 'SkillsPark program') ?></p>
                    <h3><a href="<?= h(url('/training/program/' . $item['slug'])) ?>"><?= h($item['title']) ?></a></h3>
                    <p><?= h($item['summary']) ?></p>
                    <p class="program-selector-card__ideal"><strong>Ideal for:</strong> <?= h($item['audience']) ?></p>
                    <a class="text-link" href="<?= h(url('/training/program/' . $item['slug'])) ?>">View program <?= icon('arrow') ?></a>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<section class="section section--soft learning-builds-section"><div class="container story-block__grid"><div class="reveal"><p class="eyebrow">LEARNING BY BUILDING</p><h2>Every learner is expected to make something.</h2><p>SkillsPark combines instruction with practical project work so learners can apply what they have learned instead of stopping at theory. Across creative, technical and digital courses, practical work helps learners develop confidence, demonstrate progress and leave with evidence of what they can do.</p><p>The goal is not simply to understand the tools. Learners are expected to use them to create work that demonstrates practical capability.</p></div><div class="editorial-media-grid editorial-media-grid--trio reveal"><picture class="editorial-media editorial-media--large"><source type="image/webp" srcset="<?= h(asset('images/training/graphic-design-final-project/graphic-design-final-project-480.webp')) ?> 480w, <?= h(asset('images/training/graphic-design-final-project/graphic-design-final-project-768.webp')) ?> 768w, <?= h(asset('images/training/graphic-design-final-project/graphic-design-final-project-1200.webp')) ?> 1200w" sizes="(max-width: 860px) calc(100vw - 32px), 34vw"><img src="<?= h(asset('images/training/graphic-design-final-project/graphic-design-final-project-768.jpg')) ?>" srcset="<?= h(asset('images/training/graphic-design-final-project/graphic-design-final-project-480.jpg')) ?> 480w, <?= h(asset('images/training/graphic-design-final-project/graphic-design-final-project-768.jpg')) ?> 768w, <?= h(asset('images/training/graphic-design-final-project/graphic-design-final-project-1200.jpg')) ?> 1200w" sizes="(max-width: 860px) calc(100vw - 32px), 34vw" width="1200" height="675" loading="lazy" alt="SkillsPark graphic design final project work used as practical assessment evidence."></picture><picture class="editorial-media"><source type="image/webp" srcset="<?= h(asset('images/training/video-editing-final-project/video-editing-final-project-480.webp')) ?> 480w, <?= h(asset('images/training/video-editing-final-project/video-editing-final-project-768.webp')) ?> 768w, <?= h(asset('images/training/video-editing-final-project/video-editing-final-project-1200.webp')) ?> 1200w" sizes="(max-width: 860px) calc((100vw - 44px) / 2), 18vw"><img src="<?= h(asset('images/training/video-editing-final-project/video-editing-final-project-480.jpg')) ?>" srcset="<?= h(asset('images/training/video-editing-final-project/video-editing-final-project-480.jpg')) ?> 480w, <?= h(asset('images/training/video-editing-final-project/video-editing-final-project-768.jpg')) ?> 768w, <?= h(asset('images/training/video-editing-final-project/video-editing-final-project-1200.jpg')) ?> 1200w" sizes="(max-width: 860px) calc((100vw - 44px) / 2), 18vw" width="1200" height="675" loading="lazy" alt="SkillsPark learners working from script to final video edit."></picture><picture class="editorial-media"><source type="image/webp" srcset="<?= h(asset('images/training/advanced-video-editing-project/advanced-video-editing-project-480.webp')) ?> 480w, <?= h(asset('images/training/advanced-video-editing-project/advanced-video-editing-project-768.webp')) ?> 768w, <?= h(asset('images/training/advanced-video-editing-project/advanced-video-editing-project-1200.webp')) ?> 1200w" sizes="(max-width: 860px) calc((100vw - 44px) / 2), 18vw"><img src="<?= h(asset('images/training/advanced-video-editing-project/advanced-video-editing-project-480.jpg')) ?>" srcset="<?= h(asset('images/training/advanced-video-editing-project/advanced-video-editing-project-480.jpg')) ?> 480w, <?= h(asset('images/training/advanced-video-editing-project/advanced-video-editing-project-768.jpg')) ?> 768w, <?= h(asset('images/training/advanced-video-editing-project/advanced-video-editing-project-1200.jpg')) ?> 1200w" sizes="(max-width: 860px) calc((100vw - 44px) / 2), 18vw" width="1200" height="900" loading="lazy" alt="A SkillsPark learner building confidence through a complete advanced video edit."></picture></div></div></section>
<section class="section">
    <div class="container">
        <div class="section-heading">
            <p class="eyebrow">Explore course areas</p>
            <h2>Subjects taught inside SkillsPark programs.</h2>
            <p>Course areas are grouped by discipline so learners can understand what may be available without creating thin pages for every subject.</p>
        </div>
        <div class="course-catalogue-grid">
            <?php foreach ($catalogue as $category): ?>
                <article class="course-category-card reveal">
                    <h3><?= h($category['title']) ?></h3>
                    <p><?= h($category['summary']) ?></p>
                    <div class="course-mini-list">
                        <?php foreach ($category['courses'] as $course): ?>
                            <div class="course-mini-card">
                                <h4><?= h($course['title']) ?></h4>
                                <p><?= h($course['description']) ?></p>
                                <small><?= h(implode(' / ', $course['programs'])) ?></small>
                                <?php if (!empty($course['url'])): ?><a class="text-link" href="<?= h(url($course['url'])) ?>">View evidence-backed detail <?= icon('arrow') ?></a><?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<section class="section section--soft">
    <div class="container split-heading">
        <div>
            <p class="eyebrow">Teaching approach</p>
            <h2>Practical learning with supporting theory.</h2>
            <p>SkillsPark combines explanation, guided participation, project work and reflection across its training routes.</p>
        </div>
        <a class="text-link" href="<?= h(url('/training')) ?>">View how we teach <?= icon('arrow') ?></a>
    </div>
</section>
<section class="section">
    <div class="container">
        <div class="section-heading split-heading"><div><p class="eyebrow">Audience pathways</p><h2>Training shaped around who is learning.</h2></div><a class="text-link" href="<?= h(url('/training')) ?>">Training overview <?= icon('arrow') ?></a></div>
        <div class="audience-grid"><?php foreach (published($training['audiences']) as $index => $audience): ?><a class="audience-card reveal" href="<?= h(url('/training/' . $audience['slug'])) ?>"><span>0<?= $index + 1 ?></span><h3><?= h($audience['title']) ?></h3><p><?= h($audience['summary']) ?></p><?= icon('arrow') ?></a><?php endforeach; ?></div>
    </div>
</section>
<?php $ctaTitle='Looking for the right training path?'; $ctaText='Share the learner profile and goal. SkillsPark will confirm suitable courses, delivery format, schedule and current pricing directly.'; $ctaLabel='Ask About Training'; $ctaUrl='/contact'; require ROOT_PATH . '/app/views/components/cta.php'; ?>
