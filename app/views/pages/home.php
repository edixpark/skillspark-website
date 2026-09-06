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
$projects = published(content('projects'));
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
        <div class="hero__visual reveal">
            <img src="<?= h(asset('images/hero-abstract.svg')) ?>" width="720" height="720" alt="Branded abstract composition representing learning, business transformation and education technology" fetchpriority="high">
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
            <img src="<?= h(asset('images/story-abstract.svg')) ?>" width="720" height="620" loading="lazy" alt="Abstract editorial composition representing the SkillsPark story">
        </div>
        <div class="reveal">
            <p class="eyebrow">The SkillsPark story</p>
            <h2>Teaching technology was the beginning—not the boundary.</h2>
            <p>SkillsPark started in 2024 with a practical technology and vocational training focus in the Kano/Zaria Road area. That learn-by-doing foundation now supports a broader mission: helping people develop useful capability while helping businesses and institutions solve problems through technology, creative services and digital transformation.</p>
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
            <h2>Evidence presented without inflated claims.</h2>
            <p>Our public record grows from verified activities, approved media and outcomes that can be stated responsibly.</p>
        </div>
        <div class="case-list">
            <?php foreach ($projects as $project): ?>
                <article class="case-row reveal">
                    <div>
                        <span class="tag"><?= h($project['category']) ?></span>
                        <h3><a href="<?= h(url('/work/case-studies/' . $project['slug'])) ?>"><?= h($project['title']) ?></a></h3>
                        <p><?= h($project['objective']) ?></p>
                    </div>
                    <a class="circle-link" href="<?= h(url('/work/case-studies/' . $project['slug'])) ?>" aria-label="Read <?= h($project['title']) ?>"><?= icon('arrow') ?></a>
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
                    <img src="<?= h(url($item['image'])) ?>" width="720" height="540" loading="lazy" alt="<?= h($item['alt']) ?>">
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
            <?php foreach ($achievements as $item): ?>
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
            <p class="eyebrow">SkillsPark product</p>
            <h2>EdixPark: digital infrastructure for school operations and online learning.</h2>
            <p>EdixPark connects the founder’s journey from teaching technology to building technology for educational institutions.</p>
            <a class="button" href="<?= h(url('/edixpark')) ?>">Discover EdixPark</a>
        </div>
        <div class="product-map reveal">
            <?php foreach (['Administration', 'Academics', 'Communication', 'Learning', 'Reporting'] as $area): ?>
                <span><?= h($area) ?></span>
            <?php endforeach; ?>
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
require ROOT_PATH . '/app/views/components/cta.php';
?>
