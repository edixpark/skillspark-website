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
        '/' => 'SkillsPark Tech Hub provides technology services, practical technology training and education technology solutions for people and organizations in Nigeria.',
        '/about' => 'Learn how SkillsPark Tech Hub grew from practical technology training in Kano into a technology, creative-services and education-technology hub.',
        '/services' => 'Explore SkillsPark Tech Hub technology services, including software, web development, digital transformation, branding, media and technical support.',
        '/training' => 'Explore practical technology training from SkillsPark Tech Hub for children, students, adults, schools and organizational teams.',
        '/training/programs' => 'Explore practical SkillsPark programs in web development, design, robotics, AI productivity and hardware.',
        '/work' => 'Explore SkillsPark Tech Hub work and impact through responsibly documented training, partnerships, learner stories and technology activity.',
        '/gallery' => 'An accessible, consent-aware visual record of SkillsPark classes, programs and project work.',
        '/edixpark' => 'EdixPark is a distinct education-technology platform built within the SkillsPark ecosystem, providing flexible digital infrastructure for schools.',
        '/founder' => 'A verified founder profile for SkillsPark Tech Hub is being prepared.',
        '/insights' => 'Read practical SkillsPark Tech Hub perspectives on technology learning, digital presence and organizational improvement.',
        '/contact' => 'Contact SkillsPark Tech Hub about technology services, practical training, school solutions or partnerships from Kano and for Abuja service delivery.',
        '/request-consultation' => 'Discuss a technology project, software, web development or digital transformation need with SkillsPark Tech Hub.',
        '/privacy-policy' => 'How the SkillsPark website handles enquiries, cookies, media, children’s photographs, retention and privacy requests.',
        '/terms' => 'Terms for using the public SkillsPark Tech Hub website and requesting information about services.',
        '/abuja' => 'SkillsPark Tech Hub provides technology services, practical training and digital improvement support for organizations serving Abuja and the FCT.',
        '/work/case-studies' => 'SkillsPark case studies structured around objectives, challenges, approaches and verified outcomes.',
        '/work/achievements' => 'Verified organizational, training and product milestones from SkillsPark Tech Hub.',
        '/work/partnerships' => 'SkillsPark’s approach to local and international training, technology and education partnerships.',
    ];
    $titles = [
        '/' => 'SkillsPark Tech Hub | Technology Services and Practical Training',
        '/about' => 'About SkillsPark Tech Hub | Technology, Training and EdixPark',
        '/services' => 'Technology Services | SkillsPark Tech Hub',
        '/training' => 'Practical Technology Training | SkillsPark Tech Hub',
        '/training/programs' => 'Technology Training Programs | SkillsPark Tech Hub',
        '/work' => 'Work and Impact | SkillsPark Tech Hub',
        '/gallery' => 'SkillsPark Gallery | Practical Technology Learning',
        '/founder' => 'Founder Profile | SkillsPark Tech Hub',
        '/insights' => 'Technology Insights and Tutorials | SkillsPark Tech Hub',
        '/contact' => 'Contact SkillsPark Tech Hub | Kano and Abuja Service Delivery',
        '/request-consultation' => 'Request a Project Consultation | SkillsPark Tech Hub',
        '/abuja' => 'Technology Services and Training for Abuja | SkillsPark Tech Hub',
        '/work/case-studies' => 'Technology Training Case Studies | SkillsPark Tech Hub',
        '/work/achievements' => 'SkillsPark Tech Hub Achievements and Milestones',
        '/work/partnerships' => 'SkillsPark Tech Hub Partnerships',
    ];

    if ($method === 'POST' && in_array($path, ['/contact', '/request-consultation'], true)) {
        require ROOT_PATH . '/app/handlers/contact.php';
        handle_form($path === '/contact' ? 'contact' : 'consultation');
    }
    if ($method !== 'GET') render('errors/404', ['seo' => seo_defaults(['title' => 'Page not found | SkillsPark', 'robots' => 'noindex,nofollow'])], 404);

    if ($path === '/edixpark') {
        render('pages/edixpark', ['seo' => seo_defaults([
            'title' => 'EdixPark | Education Technology Platform Built Within SkillsPark',
            'description' => 'EdixPark is SkillsPark Tech Hub\'s digital education infrastructure platform for school operations, online learning and connected delivery through School, Learn and Suite.',
            'image' => asset('images/edixpark/edixpark-logo.png'),
        ])]);
    }

    if (isset($pages[$path])) {
        [$view, $title] = $pages[$path];
        $seo = ['title' => $titles[$path] ?? $title . ' | SkillsPark Tech Hub', 'description' => $descriptions[$path] ?? content('site')['description']];
        if ($path === '/founder') $seo['robots'] = 'noindex,follow,max-image-preview:large';
        render('pages/' . $view, ['seo' => seo_defaults($seo)]);
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
    $paths = ['/', '/about', '/services', '/training', '/training/programs', '/work', '/gallery', '/edixpark', '/insights', '/contact', '/request-consultation', '/privacy-policy', '/terms', '/abuja', '/work/case-studies', '/work/achievements', '/work/partnerships'];
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
