<?php $contact = config('contact', []); ?>
<footer class="site-footer">
    <div class="container footer-grid">
        <div class="footer-brand">
            <img src="<?= h(asset('brand/skillspark-wordmark-light.svg')) ?>" width="190" height="48" alt="SkillsPark Tech Hub">
            <p><?= h($site['description']) ?></p>
            <p class="footer-tagline"><?= h($site['tagline']) ?></p>
        </div>
        <div><h2>Company</h2><ul><li><a href="<?= h(url('/about')) ?>">About SkillsPark</a></li><li><a href="<?= h(url('/founder')) ?>">Founder</a></li><li><a href="<?= h(url('/abuja')) ?>">Serving Abuja</a></li><li><a href="<?= h(url('/edixpark')) ?>">EdixPark</a></li></ul></div>
        <div><h2>Explore</h2><ul><li><a href="<?= h(url('/services')) ?>">Services</a></li><li><a href="<?= h(url('/training')) ?>">Training</a></li><li><a href="<?= h(url('/work')) ?>">Work & Impact</a></li><li><a href="<?= h(url('/gallery')) ?>">Gallery</a></li></ul></div>
        <div><h2>Resources</h2><ul><li><a href="<?= h(url('/insights')) ?>">Insights & Tutorials</a></li><li><a href="<?= h(url('/work/case-studies')) ?>">Case Studies</a></li><li><a href="<?= h(url('/privacy-policy')) ?>">Privacy</a></li><li><a href="<?= h(url('/terms')) ?>">Terms</a></li></ul></div>
        <div><h2>Contact</h2><ul><li><a href="<?= h(url('/request-consultation')) ?>">Request a Consultation</a></li><li><a href="<?= h(url('/contact')) ?>">Contact SkillsPark</a></li>
            <?php if (!empty($contact['email'])): ?><li><a href="mailto:<?= h($contact['email']) ?>"><?= h($contact['email']) ?></a></li><?php endif; ?>
            <?php if (!empty($contact['phone'])): ?><li><a href="tel:<?= h(preg_replace('/[^+0-9]/', '', $contact['phone'])) ?>"><?= h($contact['phone']) ?></a></li><?php endif; ?>
            <?php foreach (($contact['locations'] ?? []) as $location): ?><li><?= h($location) ?></li><?php endforeach; ?>
            <?php if (!empty($contact['hours'])): ?><li><?= h($contact['hours']) ?></li><?php endif; ?>
        </ul></div>
    </div>
    <div class="container footer-bottom"><p>© <?= date('Y') ?> SkillsPark Tech Hub.</p><div><a href="<?= h(url('/privacy-policy')) ?>">Privacy</a><a href="<?= h(url('/terms')) ?>">Terms</a></div></div>
</footer>
<?php if (!empty($contact['whatsapp'])): ?>
<a class="whatsapp-fab" href="https://wa.me/<?= h(preg_replace('/\D/', '', $contact['whatsapp'])) ?>" rel="noopener" target="_blank"><?= icon('chat') ?><span>Chat with SkillsPark</span></a>
<?php endif; ?>
