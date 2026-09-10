<?php
$allServices = published(content('services'));
$services = [];

foreach ([
    'technology-and-software',
    'web-design-and-development',
    'business-digital-transformation',
    'branding-and-graphic-design',
] as $slug) {
    $service = find_by_slug($allServices, $slug);
    if ($service) {
        $services[] = $service;
    }
}

$trainingData = content('training');
$programs = array_values(array_filter(
    published($trainingData['programs']),
    static fn ($item) => $item['featured'] ?? false
));
$impactStories = published(content('impact')['stories']);
$gallery = array_values(array_filter(
    published(content('gallery')),
    static fn ($item) => ($item['consent_confirmed'] ?? false) === true
));
$achievements = published(content('achievements'));
$partners = published(content('partners'));
$insights = published(content('insights'));
$founder = content('founder');
?>

<section class="hero">
    <div class="container hero__grid">
        <div class="hero__content reveal">
            <p class="eyebrow">Technology company, solutions hub and professional training</p>
            <h1><?= h($site['primary_message']) ?></h1>
            <p class="lead"><?= h($site['description']) ?></p>
            <div class="button-row">
                <a class="button" href="<?= h(url('/services')) ?>">Explore Technology Services</a>
                <a class="button button--outline-light" href="<?= h(url('/training')) ?>">Explore Training Programs</a>
            </div>
        </div>
        <div class="hero__visual hero-media reveal">
            <picture class="hero-media__primary">
                <source type="image/webp" srcset="<?= h(asset('images/training/hardware/skillspark-hands-on-hardware-training-480.webp')) ?> 480w, <?= h(asset('images/training/hardware/skillspark-hands-on-hardware-training-768.webp')) ?> 768w, <?= h(asset('images/training/hardware/skillspark-hands-on-hardware-training-1200.webp')) ?> 1200w" sizes="(max-width: 600px) calc(100vw - 32px), (max-width: 860px) 62vw, (max-width: 1280px) 28vw, 360px">
                <img src="<?= h(asset('images/training/hardware/skillspark-hands-on-hardware-training-768.jpg')) ?>" srcset="<?= h(asset('images/training/hardware/skillspark-hands-on-hardware-training-480.jpg')) ?> 480w, <?= h(asset('images/training/hardware/skillspark-hands-on-hardware-training-768.jpg')) ?> 768w, <?= h(asset('images/training/hardware/skillspark-hands-on-hardware-training-1200.jpg')) ?> 1200w" sizes="(max-width: 600px) calc(100vw - 32px), (max-width: 860px) 62vw, (max-width: 1280px) 28vw, 360px" width="1200" height="900" alt="Participants working on an open desktop computer during SkillsPark hardware training." fetchpriority="high" decoding="async">
            </picture>
            <picture class="hero-media__support">
                <source type="image/webp" srcset="<?= h(asset('images/training/young-learners/skillspark-young-learners-software-class-480.webp')) ?> 480w, <?= h(asset('images/training/young-learners/skillspark-young-learners-software-class-768.webp')) ?> 768w, <?= h(asset('images/training/young-learners/skillspark-young-learners-software-class-1200.webp')) ?> 1200w" sizes="(max-width: 860px) 32vw, (max-width: 1280px) 16vw, 210px">
                <img src="<?= h(asset('images/training/young-learners/skillspark-young-learners-software-class-480.jpg')) ?>" srcset="<?= h(asset('images/training/young-learners/skillspark-young-learners-software-class-480.jpg')) ?> 480w, <?= h(asset('images/training/young-learners/skillspark-young-learners-software-class-768.jpg')) ?> 768w, <?= h(asset('images/training/young-learners/skillspark-young-learners-software-class-1200.jpg')) ?> 1200w" sizes="(max-width: 860px) 32vw, (max-width: 1280px) 16vw, 210px" width="1200" height="900" alt="Young learners working on laptops during a SkillsPark technology class." decoding="async">
            </picture>
            <picture class="hero-media__support">
                <source type="image/webp" srcset="<?= h(asset('images/training/creative-media/skillspark-video-editing-training-480.webp')) ?> 480w, <?= h(asset('images/training/creative-media/skillspark-video-editing-training-768.webp')) ?> 768w, <?= h(asset('images/training/creative-media/skillspark-video-editing-training-1200.webp')) ?> 1200w" sizes="(max-width: 860px) 32vw, (max-width: 1280px) 16vw, 210px">
                <img src="<?= h(asset('images/training/creative-media/skillspark-video-editing-training-480.jpg')) ?>" srcset="<?= h(asset('images/training/creative-media/skillspark-video-editing-training-480.jpg')) ?> 480w, <?= h(asset('images/training/creative-media/skillspark-video-editing-training-768.jpg')) ?> 768w, <?= h(asset('images/training/creative-media/skillspark-video-editing-training-1200.jpg')) ?> 1200w" sizes="(max-width: 860px) 32vw, (max-width: 1280px) 16vw, 210px" width="1200" height="900" alt="A participant practising video editing on a laptop during SkillsPark training." decoding="async">
            </picture>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="section-heading reveal">
            <p class="eyebrow">One connected hub</p>
            <h2>Four ways SkillsPark creates useful progress.</h2>
            <p>From first practical skills to stronger organizations and education technology, each pillar responds to a different stage of growth.</p>
        </div>
        <div class="pillar-grid">
            <?php foreach ($site['pillars'] as $pillar): ?>
                <article class="pillar-card reveal">
                    <span><?= icon($pillar['icon']) ?></span>
                    <h3><?= h($pillar['title']) ?></h3>
                    <p><?= h($pillar['text']) ?></p>
                    <a class="text-link" href="<?= h(url($pillar['url'])) ?>">Explore <?= icon('arrow') ?></a>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="section section--soft">
    <div class="container">
        <div class="section-heading split-heading">
            <div>
                <p class="eyebrow">Featured services</p>
                <h2>Practical capability for real organizational needs.</h2>
            </div>
            <a class="text-link" href="<?= h(url('/services')) ?>">View all services <?= icon('arrow') ?></a>
        </div>
        <div class="card-grid card-grid--4">
            <?php foreach ($services as $item) {
                require ROOT_PATH . '/app/views/components/service-card.php';
            } ?>
        </div>
    </div>
</section>

<section class="section audience-section">
    <div class="container">
        <div class="section-heading reveal">
            <p class="eyebrow">Solutions by audience</p>
            <h2>Start with your context, not a catalogue.</h2>
        </div>
        <div class="audience-grid">
            <?php foreach ($site['audiences'] as $index => $audience): ?>
                <a class="audience-card reveal" href="<?= h(url('/solutions/' . $audience['slug'])) ?>">
                    <span>0<?= $index + 1 ?></span>
                    <h3><?= h($audience['title']) ?></h3>
                    <p><?= h($audience['text']) ?></p>
                    <?= icon('arrow') ?>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="section story-block">
    <div class="container story-block__grid">
        <div class="story-art reveal">
            <picture>
                <source type="image/webp" srcset="<?= h(asset('images/story/skillspark-learning-space-wide-768.webp')) ?> 768w, <?= h(asset('images/story/skillspark-learning-space-wide-1200.webp')) ?> 1200w, <?= h(asset('images/story/skillspark-learning-space-wide-1600.webp')) ?> 1600w" sizes="(max-width: 860px) calc(100vw - 32px), 50vw">
                <img src="<?= h(asset('images/story/skillspark-learning-space-wide-768.jpg')) ?>" srcset="<?= h(asset('images/story/skillspark-learning-space-wide-768.jpg')) ?> 768w, <?= h(asset('images/story/skillspark-learning-space-wide-1200.jpg')) ?> 1200w, <?= h(asset('images/story/skillspark-learning-space-wide-1600.jpg')) ?> 1600w" sizes="(max-width: 860px) calc(100vw - 32px), 50vw" width="1600" height="900" loading="lazy" alt="A SkillsPark learning space with participants working on laptops.">
            </picture>
        </div>
        <div class="reveal">
            <p class="eyebrow">The SkillsPark story</p>
            <h2>Teaching technology was the beginning—not the boundary.</h2>
            <p>SkillsPark started in 2024 with a practical technology and vocational training focus at Zaria Road, Kano State, Nigeria. That learn-by-doing foundation now supports a broader mission: helping people develop useful capability while helping businesses and institutions solve problems through technology, creative services and digital transformation.</p>
            <a class="button button--outline" href="<?= h(url('/about')) ?>">Read Our Story</a>
        </div>
    </div>
</section>

<section class="section section--navy">
    <div class="container">
        <div class="section-heading split-heading">
            <div>
                <p class="eyebrow">Featured training</p>
                <h2>Learning becomes valuable when it can be used.</h2>
            </div>
            <a class="text-link text-link--light" href="<?= h(url('/training/programs')) ?>">Explore programs <?= icon('arrow') ?></a>
        </div>
        <div class="card-grid card-grid--4">
            <?php foreach ($programs as $item) {
                require ROOT_PATH . '/app/views/components/program-card.php';
            } ?>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="section-heading reveal">
            <p class="eyebrow">Work & impact</p>
            <h2>Real activity, described with care.</h2>
            <p>Explore practical training, learner entrepreneurship, community learning and international collaboration—without unsupported numbers or claims.</p>
        </div>
        <div class="case-list">
            <?php foreach (array_slice($impactStories, 0, 4) as $story): ?>
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

<section class="section section--soft">
    <div class="container">
        <div class="section-heading split-heading">
            <div>
                <p class="eyebrow">Gallery preview</p>
                <h2>Learning, making and collaboration.</h2>
            </div>
            <a class="text-link" href="<?= h(url('/gallery')) ?>">Open gallery <?= icon('arrow') ?></a>
        </div>
        <div class="gallery-grid gallery-grid--preview">
            <?php foreach (array_slice($gallery, 0, 3) as $item): ?>
                <figure class="gallery-item reveal">
                    <picture>
                        <?php if (!empty($item['webp_srcset'])): ?><source type="image/webp" srcset="<?= h($item['webp_srcset']) ?>" sizes="(max-width: 600px) 100vw, 33vw"><?php endif; ?>
                        <img src="<?= h(url($item['image'])) ?>" <?= !empty($item['srcset']) ? 'srcset="'.h($item['srcset']).'" sizes="(max-width: 600px) 100vw, 33vw"' : '' ?> width="720" height="540" loading="lazy" alt="<?= h($item['alt']) ?>">
                    </picture>
                    <figcaption>
                        <strong><?= h($item['title']) ?></strong>
                        <span><?= h($item['category']) ?></span>
                    </figcaption>
                </figure>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="section-heading reveal">
            <p class="eyebrow">Verified milestones</p>
            <h2>A young organization with a clear direction.</h2>
        </div>
        <div class="timeline timeline--horizontal">
            <?php foreach (array_slice($achievements, 0, 3) as $item): ?>
                <article class="reveal">
                    <span><?= h($item['date'] ?: $item['category']) ?></span>
                    <h3><?= h($item['title']) ?></h3>
                    <p><?= h($item['summary']) ?></p>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php if ($partners): ?>
    <section class="section section--soft">
        <div class="container">
            <div class="section-heading">
                <p class="eyebrow">Partnerships</p>
                <h2>Collaborating with care.</h2>
            </div>
            <div class="card-grid">
                <?php foreach ($partners as $partner): ?>
                    <article class="card">
                        <h3><?= h($partner['name']) ?></h3>
                        <p><?= h($partner['summary']) ?></p>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
<?php endif; ?>

<section class="section edix-feature">
    <div class="container edix-feature__grid">
        <div class="reveal">
            <p class="eyebrow">Education technology platform</p>
            <img class="edixpark-logo edixpark-logo--feature" src="<?= h(asset('images/edixpark/edixpark-logo.png')) ?>" width="1600" height="305" alt="EdixPark">
            <h2>EdixPark: digital infrastructure for operations and online learning.</h2>
            <p>Built within the SkillsPark technology ecosystem, EdixPark gives schools and educational institutions structured tools for daily operations, branded online learning and connected digital growth through EdixPark School, Learn and Suite.</p>
            <div class="button-row"><a class="button" href="<?= h(url('/edixpark')) ?>">Explore EdixPark</a><a class="button button--outline" href="https://edixpark.com/" target="_blank" rel="noopener noreferrer" aria-label="Visit EdixPark.com (opens in a new tab)">Visit EdixPark.com <?= icon('arrow') ?></a></div>
        </div>
        <div class="edixpark-home-panel reveal">
            <p>One product family for structured operations, branded learning and connected institutional delivery.</p>
            <div>
                <?php foreach (['EdixPark School', 'EdixPark Learn', 'EdixPark Suite'] as $area): ?>
                    <span><?= h($area) ?></span>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>

<section class="section">
    <div class="container founder-preview">
        <div class="founder-placeholder reveal" aria-hidden="true"><?= icon('person') ?></div>
        <div class="reveal">
            <p class="eyebrow">The founder’s journey</p>
            <h2>From teaching technology to building technology.</h2>
            <p><?= h($founder['journey']) ?></p>
            <a class="text-link" href="<?= h(url('/founder')) ?>">View founder profile <?= icon('arrow') ?></a>
        </div>
    </div>
</section>

<?php if (published(content('testimonials'))): ?>
    <section class="section section--soft">
        <div class="container">
            <div class="section-heading">
                <p class="eyebrow">Testimonials</p>
                <h2>What participants and partners say.</h2>
            </div>
        </div>
    </section>
<?php endif; ?>

<section class="section abuja-callout">
    <div class="container abuja-callout__inner reveal">
        <div>
            <p class="eyebrow">Abuja service presence</p>
            <h2>Technology, creative services and practical improvement for Abuja organizations.</h2>
            <p>Serving schools, SMEs, startups, NGOs, training institutions and teams through scoped engagements.</p>
        </div>
        <a class="button" href="<?= h(url('/abuja')) ?>">Explore Abuja Solutions</a>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="section-heading split-heading">
            <div>
                <p class="eyebrow">Insights & tutorials</p>
                <h2>Useful thinking for learning and digital growth.</h2>
            </div>
            <a class="text-link" href="<?= h(url('/insights')) ?>">View all insights <?= icon('arrow') ?></a>
        </div>
        <div class="card-grid card-grid--3">
            <?php foreach (array_slice($insights, 0, 3) as $article): ?>
                <article class="insight-card reveal">
                    <span class="tag"><?= h($article['category']) ?></span>
                    <h3><a href="<?= h(url('/insights/' . $article['slug'])) ?>"><?= h($article['title']) ?></a></h3>
                    <p><?= h($article['summary']) ?></p>
                    <a class="text-link" href="<?= h(url('/insights/' . $article['slug'])) ?>">Read insight <?= icon('arrow') ?></a>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php
$ctaTitle = 'What could technology help you do better?';
$ctaText = 'Bring the goal, the challenge or the early idea. We will help you shape a practical next step.';
$ctaLabel = 'Contact SkillsPark';
$ctaUrl = '/contact';
$ctaSecondaryLabel = 'WhatsApp SkillsPark';
$ctaSecondaryUrl = whatsapp_url('Hello SkillsPark, I would like to make an enquiry.');
require ROOT_PATH . '/app/views/components/cta.php';
?>
