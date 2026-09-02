<?php

declare(strict_types=1);

function route_request(string $method, string $path): void
{
    $pages = [
        '/' => ['home', 'Home'], '/about' => ['about', 'About SkillsPark'], '/services' => ['services', 'Services'],
        '/training' => ['training', 'Training'], '/training/programs' => ['programs', 'Training Programs'], '/work' => ['work', 'Work & Impact'],
        '/gallery' => ['gallery', 'Gallery'], '/edixpark' => ['edixpark', 'EdixPark'], '/founder' => ['founder', 'Founder'],
        '/insights' => ['insights', 'Insights'], '/contact' => ['contact', 'Contact'], '/request-consultation' => ['consultation', 'Request a Consultation'],
        '/privacy-policy' => ['privacy', 'Privacy Policy'], '/terms' => ['terms', 'Terms of Use'], '/abuja' => ['abuja', 'Serving Abuja'],
        '/work/case-studies' => ['case-studies', 'Case Studies'], '/work/achievements' => ['achievements', 'Achievements'], '/work/partnerships' => ['partnerships', 'Partnerships'],
    ];
    $descriptions = [
        '/' => 'Practical technology training, creative services, digital transformation and education software from SkillsPark Tech Hub.',
        '/about' => 'The SkillsPark story, mission, values and evolution from practical training centre to technology-solutions hub.',
        '/services' => 'Explore SkillsPark software, web, branding, media, transformation, 3D, social media and hardware services.',
        '/training' => 'Project-based technology training for children, students, adults, schools and organizational teams.',
        '/training/programs' => 'Explore practical SkillsPark programs in web development, design, robotics, AI productivity and hardware.',
        '/work' => 'Verified SkillsPark case studies, activities, achievements and partnership information.',
        '/gallery' => 'An accessible, consent-aware visual record of SkillsPark classes, programs and project work.',
        '/edixpark' => 'EdixPark is digital infrastructure for school operations and online learning, connected to the SkillsPark journey.',
        '/founder' => 'The founder’s journey from teaching technology through SkillsPark to building education technology with EdixPark.',
        '/insights' => 'Practical SkillsPark perspectives on technology learning, education, digital presence and organizational growth.',
        '/contact' => 'Contact SkillsPark Tech Hub about training, services, partnerships and EdixPark.',
        '/request-consultation' => 'Request a focused SkillsPark consultation for a technology, training, creative or digital transformation need.',
        '/privacy-policy' => 'How the SkillsPark website handles enquiries, cookies, media, children’s photographs, retention and privacy requests.',
        '/terms' => 'Terms for using the public SkillsPark Tech Hub website and requesting information about services.',
        '/abuja' => 'Technology services, digital-presence support, staff training and EdixPark outreach for organizations serving Abuja.',
        '/work/case-studies' => 'SkillsPark case studies structured around objectives, challenges, approaches and verified outcomes.',
        '/work/achievements' => 'Verified organizational, training and product milestones from SkillsPark Tech Hub.',
        '/work/partnerships' => 'SkillsPark’s approach to local and international training, technology and education partnerships.',
    ];

    if ($method === 'POST' && in_array($path, ['/contact', '/request-consultation'], true)) {
        require ROOT_PATH . '/app/handlers/contact.php';
        handle_form($path === '/contact' ? 'contact' : 'consultation');
    }
    if ($method !== 'GET') render('errors/404', ['seo' => seo_defaults(['title' => 'Page not found | SkillsPark', 'robots' => 'noindex,nofollow'])], 404);

    if (isset($pages[$path])) {
        [$view, $title] = $pages[$path];
        render('pages/' . $view, ['seo' => seo_defaults(['title' => $title . ' | SkillsPark Tech Hub', 'description' => $descriptions[$path] ?? content('site')['description']])]);
    }
    if (preg_match('#^/services/([a-z0-9-]+)$#', $path, $match)) {
        $service = find_by_slug(content('services'), $match[1]);
        if ($service) render('pages/service-detail', ['service' => $service, 'seo' => seo_defaults(['title' => $service['seo_title'], 'description' => $service['seo_description']])]);
    }
    if (preg_match('#^/training/([a-z0-9-]+)$#', $path, $match)) {
        $training = content('training');
        $audience = find_by_slug($training['audiences'], $match[1]);
        if ($audience) render('pages/training-detail', ['audience' => $audience, 'seo' => seo_defaults(['title' => $audience['seo_title'], 'description' => $audience['seo_description']])]);
    }
    if (preg_match('#^/training/program/([a-z0-9-]+)$#', $path, $match)) {
        $program = find_by_slug(content('training')['programs'], $match[1]);
        if ($program) render('pages/program-detail', ['program' => $program, 'seo' => seo_defaults(['title' => $program['title'] . ' | SkillsPark Training', 'description' => $program['summary']])]);
    }
    if (preg_match('#^/solutions/(schools|businesses|organizations|individuals)$#', $path, $match)) {
        $audience = find_by_slug(array_map(static fn ($item) => $item + ['published' => true], content('site')['audiences']), $match[1]);
        if ($audience) render('pages/solution', ['audience' => $audience, 'seo' => seo_defaults(['title' => 'Solutions for ' . $audience['title'] . ' | SkillsPark', 'description' => $audience['text']])]);
    }
    if (preg_match('#^/work/case-studies/([a-z0-9-]+)$#', $path, $match)) {
        $project = find_by_slug(content('projects'), $match[1]);
        if ($project) render('pages/case-study', ['project' => $project, 'seo' => seo_defaults(['title' => $project['seo_title'], 'description' => $project['seo_description']])]);
    }
    if (preg_match('#^/insights/([a-z0-9-]+)$#', $path, $match)) {
        $article = find_by_slug(content('insights'), $match[1]);
        if ($article) render('pages/article', ['article' => $article, 'seo' => seo_defaults(['title' => $article['seo_title'], 'description' => $article['seo_description'], 'type' => 'article'])]);
    }
    if ($path === '/sitemap.xml') { output_sitemap(); return; }
    if ($path === '/robots.txt') { header('Content-Type: text/plain; charset=UTF-8'); echo "User-agent: *\nAllow: /\nSitemap: " . url('/sitemap.xml') . "\n"; return; }
    render('errors/404', ['seo' => seo_defaults(['title' => 'Page not found | SkillsPark', 'description' => 'The requested page could not be found.', 'robots' => 'noindex,nofollow'])], 404);
}

function output_sitemap(): void
{
    $paths = ['/', '/about', '/services', '/training', '/training/programs', '/work', '/gallery', '/edixpark', '/founder', '/insights', '/contact', '/request-consultation', '/privacy-policy', '/terms', '/abuja', '/work/case-studies', '/work/achievements', '/work/partnerships'];
    foreach (published(content('services')) as $item) $paths[] = '/services/' . $item['slug'];
    foreach (published(content('training')['audiences']) as $item) $paths[] = '/training/' . $item['slug'];
    foreach (published(content('training')['programs']) as $item) $paths[] = '/training/program/' . $item['slug'];
    foreach (content('site')['audiences'] as $item) $paths[] = '/solutions/' . $item['slug'];
    foreach (published(content('projects')) as $item) $paths[] = '/work/case-studies/' . $item['slug'];
    foreach (published(content('insights')) as $item) $paths[] = '/insights/' . $item['slug'];
    header('Content-Type: application/xml; charset=UTF-8');
    echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n";
    foreach (array_unique($paths) as $path) echo '  <url><loc>' . h(url($path)) . "</loc></url>\n";
    echo "</urlset>\n";
}
