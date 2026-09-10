<?php
$contact = config('contact', []);
$socialIcons = ['Facebook' => 'social-facebook', 'Instagram' => 'social-instagram', 'X' => 'social-x', 'LinkedIn' => 'social-linkedin'];
$socialUrls = array_column($contact['socials'] ?? [], 'url', 'label');
$blogUrl = safe_external_url((string) ($socialUrls['SkillsPark Blog'] ?? ''));
?>
<footer class="site-footer">
    <div class="container footer-grid">
        <div class="footer-brand"><img src="<?= h(asset('images/branding/skillspark-logo.png')) ?>" width="190" height="34" alt="SkillsPark Tech Hub"><p><?= h($site['primary_message']) ?></p><ul class="footer-socials" aria-label="Follow SkillsPark"><?php foreach ($contact['socials'] as $social): $socialUrl = safe_external_url($social['url']); $socialIcon = $socialIcons[$social['label']] ?? null; if ($socialUrl && $socialIcon): ?><li><a href="<?= h($socialUrl) ?>" target="_blank" rel="noopener noreferrer" aria-label="<?= h($social['label']) ?> (opens in a new tab)" title="<?= h($social['label']) ?>"><?= icon($socialIcon) ?><span class="sr-only"><?= h($social['label']) ?></span></a></li><?php endif; endforeach; ?></ul></div>
        <div><h2>Company</h2><ul><li><a href="<?= h(url('/about')) ?>">About SkillsPark</a></li><li><a href="<?= h(url('/founder')) ?>">Founder</a></li><li><a href="<?= h(url('/abuja')) ?>">Serving Abuja</a></li><li><a href="<?= h(url('/contact')) ?>">Contact</a></li></ul></div>
        <div><h2>Services</h2><ul><li><a href="<?= h(url('/services/technology-and-software')) ?>">Technology &amp; Software Solutions</a></li><li><a href="<?= h(url('/services/web-design-and-development')) ?>">Web Design &amp; Development</a></li><li><a href="<?= h(url('/services/business-digital-transformation')) ?>">Digital Transformation</a></li><li><a href="<?= h(url('/services')) ?>">All Services</a></li></ul></div>
        <div><h2>Training</h2><ul><li><a href="<?= h(url('/training')) ?>">Training Overview</a></li><li><a href="<?= h(url('/training/programs')) ?>">Training Programs</a></li><li><a href="<?= h(url('/training/schools')) ?>">Schools</a></li><li><a href="<?= h(url('/training/corporate-training')) ?>">Corporate Training</a></li></ul></div>
        <div><h2>Explore</h2><ul><li><a href="<?= h(url('/work')) ?>">Work &amp; Impact</a></li><li><a href="<?= h(url('/work/case-studies')) ?>">Case Studies</a></li><li><a href="<?= h(url('/gallery')) ?>">Gallery</a></li><li><a href="<?= h(url('/insights')) ?>">Insights &amp; Tutorials</a></li><li><a href="<?= h(url('/edixpark')) ?>">EdixPark</a></li><?php if ($blogUrl): ?><li><a href="<?= h($blogUrl) ?>" target="_blank" rel="noopener noreferrer" aria-label="SkillsPark Blog (opens in a new tab)">SkillsPark Blog</a></li><?php endif; ?></ul></div>
        <div><h2>Legal</h2><ul><li><a href="<?= h(url('/privacy-policy')) ?>">Privacy</a></li><li><a href="<?= h(url('/terms')) ?>">Terms</a></li></ul></div>
    </div>
    <div class="container footer-bottom"><p>© <?= date('Y') ?> SkillsPark Tech Hub.</p><div><a href="<?= h(url('/privacy-policy')) ?>">Privacy</a><a href="<?= h(url('/terms')) ?>">Terms</a></div></div>
</footer>
