<?php
$allServices = published(content('services'));
$featuredServices = [];

foreach ([
    'technology-and-software',
    'web-design-and-development',
    'business-digital-transformation',
] as $slug) {
    $service = find_by_slug($allServices, $slug);
    if ($service) {
        $featuredServices[] = $service;
    }
}

$featuredSlugs = array_column($featuredServices, 'slug');
$secondaryServices = array_values(array_filter(
    $allServices,
    static fn (array $service): bool => !in_array($service['slug'], $featuredSlugs, true)
));

$trainingData = content('training');
$programs = array_slice(array_values(array_filter(
    published($trainingData['programs']),
    static fn (array $program): bool => $program['featured'] ?? false
)), 0, 3);

$projects = array_slice(published(content('projects')), 0, 2);
$gallery = array_values(array_filter(
    published(content('gallery')),
    static fn (array $item): bool => ($item['consent_confirmed'] ?? false) === true
));
$insights = array_slice(published(content('insights')), 0, 3);

$audienceLinks = [
    [
        'title' => 'Businesses',
        'text' => 'Software, websites, digital transformation and creative delivery for growth.',
        'url' => '/solutions/businesses',
    ],
    [
        'title' => 'Schools & education institutions',
        'text' => 'Education technology, staff development and practical programs.',
        'url' => '/solutions/schools',
    ],
    [
        'title' => 'Organizations',
        'text' => 'Practical technology support for NGOs, corporate and public-sector teams.',
        'url' => '/solutions/organizations',
    ],
    [
        'title' => 'Individuals & professionals',
        'text' => 'Technology support and skills for work, enterprise and growth.',
        'url' => '/solutions/individuals',
    ],
    [
        'title' => 'Learners & families',
        'text' => 'Project-based technology programs for different ages and stages.',
        'url' => '/training',
    ],
];
?>

<section class="hero hero--focused">
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
            <img src="<?= h(asset('images/hero-abstract.svg')) ?>" width="720" height="720" alt="Branded abstract composition representing technology, practical learning and education" fetchpriority="high">
        </div>
    </div>
</section>

<section class="proof-strip home-positioning" aria-label="SkillsPark capabilities">
    <div class="container proof-strip__grid">
        <div>
            <strong>Technology solutions</strong>
            <span>Software, websites and practical implementation.</span>
        </div>
        <div>
            <strong>Creative & transformation services</strong>
            <span>Clearer brands, stronger digital presence and better workflows.</span>
        </div>
        <div>
            <strong>Professional technology training</strong>
            <span>Project-based learning for people and organizations.</span>
        </div>
    </div>
</section>

<section class="section home-services">
    <div class="container">
        <div class="section-heading split-heading reveal">
            <div>
                <p class="eyebrow">Technology services</p>
                <h2>Build the systems and digital presence your organization needs.</h2>
                <p>SkillsPark combines technical delivery, creative thinking and practical support to help organizations move from a clear need to a useful result.</p>
            </div>
            <a class="text-link" href="<?= h(url('/services')) ?>">View all services <?= icon('arrow') ?></a>
        </div>

        <div class="card-grid card-grid--3 home-services__priority">
            <?php foreach ($featuredServices as $item) {
                require ROOT_PATH . '/app/views/components/service-card.php';
            } ?>
        </div>

        <?php if ($secondaryServices): ?>
            <nav class="capability-list" aria-label="More SkillsPark services">
                <?php foreach ($secondaryServices as $service): ?>
                    <a href="<?= h(url('/services/' . $service['slug'])) ?>">
                        <span><?= h($service['title']) ?></span>
                        <?= icon('arrow') ?>
                    </a>
                <?php endforeach; ?>
            </nav>
        <?php endif; ?>
    </div>
</section>

<section class="section section--navy home-training">
    <div class="container">
        <div class="home-training__intro">
            <div class="section-heading reveal">
                <p class="eyebrow">Professional technology training</p>
                <h2>Develop useful skills through guided, practical work.</h2>
            </div>
            <div class="reveal">
                <p>Programs are organized for children, students, professionals, schools and organizations. Every format emphasizes practice, responsible technology use and work learners can explain.</p>
                <a class="text-link text-link--light" href="<?= h(url('/training/programs')) ?>">Explore all programs <?= icon('arrow') ?></a>
            </div>
        </div>

        <div class="card-grid card-grid--3 home-training__programs">
            <?php foreach ($programs as $item) {
                require ROOT_PATH . '/app/views/components/program-card.php';
            } ?>
        </div>
    </div>
</section>

<section class="section section--soft home-impact">
    <div class="container">
        <div class="section-heading split-heading reveal">
            <div>
                <p class="eyebrow">Real work & impact</p>
                <h2>Evidence presented clearly, without inflated claims.</h2>
                <p>SkillsPark publishes verified activities, approved media and outcomes that can be stated responsibly.</p>
            </div>
            <a class="text-link" href="<?= h(url('/work')) ?>">Explore work & impact <?= icon('arrow') ?></a>
        </div>

        <div class="home-impact__grid">
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

            <?php if ($gallery): ?>
                <?php $galleryItem = $gallery[0]; ?>
                <a class="impact-media reveal" href="<?= h(url('/gallery')) ?>">
                    <img src="<?= h(url($galleryItem['image'])) ?>" width="720" height="540" loading="lazy" alt="<?= h($galleryItem['alt']) ?>">
                    <span>
                        <strong><?= h($galleryItem['title']) ?></strong>
                        <small>View approved activity media <?= icon('arrow') ?></small>
                    </span>
                </a>
            <?php else: ?>
                <a class="impact-media impact-media--empty reveal" href="<?= h(url('/work/case-studies')) ?>">
                    <span>
                        <strong>Explore documented work</strong>
                        <small>Read the available case studies <?= icon('arrow') ?></small>
                    </span>
                </a>
            <?php endif; ?>
        </div>
    </div>
</section>

<section class="section home-audiences">
    <div class="container">
        <div class="section-heading reveal">
            <p class="eyebrow">Find your starting point</p>
            <h2>Choose the path closest to your current need.</h2>
        </div>
        <div class="audience-links">
            <?php foreach ($audienceLinks as $audience): ?>
                <a class="audience-link reveal" href="<?= h(url($audience['url'])) ?>">
                    <span>
                        <strong><?= h($audience['title']) ?></strong>
                        <small><?= h($audience['text']) ?></small>
                    </span>
                    <?= icon('arrow') ?>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="section edix-feature home-edixpark">
    <div class="container edix-feature__grid">
        <div class="reveal">
            <p class="eyebrow">Education technology product</p>
            <h2>EdixPark supports school operations and online learning.</h2>
            <p>SkillsPark is the technology company and solutions hub. EdixPark is its related education technology product direction, focused on digital infrastructure for educational institutions.</p>
            <a class="button" href="<?= h(url('/edixpark')) ?>">Discover EdixPark</a>
        </div>
        <div class="product-map product-map--compact reveal" aria-label="EdixPark focus areas">
            <?php foreach (['Administration', 'Academics', 'Communication', 'Learning', 'Reporting'] as $area): ?>
                <span><?= h($area) ?></span>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="section section--soft home-company">
    <div class="container home-company__grid">
        <article class="home-company__story reveal">
            <p class="eyebrow">About SkillsPark</p>
            <h2>Practical learning grew into practical technology delivery.</h2>
            <p>Founded in 2024 and historically associated with the Kano/Zaria Road area, SkillsPark is developing from a training-focused organization into a broader technology company serving people, businesses and institutions.</p>
            <a class="text-link" href="<?= h(url('/about')) ?>">Read the SkillsPark story <?= icon('arrow') ?></a>
        </article>
        <article class="home-company__abuja reveal">
            <p class="eyebrow">Serving Abuja</p>
            <h2>Technology support for organizations ready to improve.</h2>
            <p>SkillsPark is expanding its service and business-development presence in Abuja. No physical Abuja office is claimed.</p>
            <a class="button button--outline" href="<?= h(url('/abuja')) ?>">Explore Abuja Solutions</a>
        </article>
    </div>
</section>

<?php if ($insights): ?>
    <section class="section home-insights">
        <div class="container">
            <div class="section-heading split-heading reveal">
                <div>
                    <p class="eyebrow">Insights & tutorials</p>
                    <h2>Useful thinking for learning and digital progress.</h2>
                </div>
                <a class="text-link" href="<?= h(url('/insights')) ?>">View all insights <?= icon('arrow') ?></a>
            </div>
            <div class="insight-list">
                <?php foreach ($insights as $article): ?>
                    <a class="insight-row reveal" href="<?= h(url('/insights/' . $article['slug'])) ?>">
                        <span><?= h($article['category']) ?></span>
                        <strong><?= h($article['title']) ?></strong>
                        <?= icon('arrow') ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
<?php endif; ?>

<?php
$ctaEyebrow = 'Start with the need';
$ctaTitle = 'What could technology help you build or improve?';
$ctaText = 'Tell SkillsPark about your organization, audience or challenge. We will help you identify a practical next step.';
$ctaLabel = 'Request a Consultation';
$ctaUrl = '/request-consultation';
require ROOT_PATH . '/app/views/components/cta.php';
?>
