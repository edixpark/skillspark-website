<?php
$title = 'Let’s talk about what you want to build, learn or improve.';
$eyebrow = 'Contact SkillsPark';
$intro = 'Whether you are exploring technology services, training, school solutions, partnerships or a general enquiry, contact SkillsPark and we’ll help direct you to the right next step.';
$breadcrumbs = [['label' => 'Home', 'url' => '/'], ['label' => 'Contact', 'url' => '/contact']];
require ROOT_PATH . '/app/views/components/page-hero.php';
$contact = config('contact');
?>
<section class="contact-topics" aria-label="Enquiry topics">
    <div class="container"><ul><?php foreach (['Technology Services', 'Training', 'Schools & Organisations', 'Partnerships'] as $topic): ?><li><?= h($topic) ?></li><?php endforeach; ?></ul></div>
</section>
<section class="section contact-main">
    <div class="container contact-layout">
        <div class="contact-form-column">
            <div class="section-heading"><p class="eyebrow">Send an enquiry</p><h2>Tell us how we can help.</h2><p>Share the essentials and we’ll route your message to the right area.</p></div>
            <?php $formType = 'contact'; require ROOT_PATH . '/app/views/components/form.php'; ?>
        </div>
        <aside class="contact-sidebar" aria-label="Contact information">
            <section class="contact-info-card"><p class="eyebrow">Direct contact</p><h2>Contact SkillsPark</h2><ul class="contact-details"><li><?= icon('phone') ?><span><strong>Phone</strong><a href="<?= h($contact['phone_uri']) ?>"><?= h($contact['phone']) ?></a></span></li><li><?= icon('mail') ?><span><strong>Email</strong><a class="wrap-link" href="<?= h($contact['email_uri']) ?>"><?= h($contact['email']) ?></a></span></li><li><?= icon('chat') ?><span><strong>WhatsApp</strong><a href="<?= h(whatsapp_url('Hello SkillsPark, I would like to make an enquiry.')) ?>" target="_blank" rel="noopener noreferrer" aria-label="Chat with SkillsPark on WhatsApp (opens in a new tab)">Chat with SkillsPark</a></span></li><li><?= icon('map') ?><span><strong>Kano</strong><?= h($contact['locations']['primary']) ?></span></li><li><?= icon('map') ?><span><strong>Abuja</strong><?= h($contact['locations']['abuja']) ?></span></li></ul></section>
            <section class="next-steps-card"><p class="eyebrow">Simple and clear</p><h2>What happens next</h2><ol><li><span>1</span><div><strong>Enquiry received</strong><p>We review the information you send.</p></div></li><li><span>2</span><div><strong>Routed to the right area</strong><p>Your enquiry is directed to the relevant SkillsPark service or training context.</p></div></li><li><span>3</span><div><strong>Follow-up</strong><p>We respond through the contact details you provided.</p></div></li></ol></section>
            <section class="contact-social"><h2>Follow SkillsPark</h2><ul><?php foreach ($contact['socials'] as $social): $socialUrl = safe_external_url($social['url']); if ($socialUrl): ?><li><a href="<?= h($socialUrl) ?>" target="_blank" rel="noopener noreferrer" aria-label="<?= h($social['label']) ?> (opens in a new tab)"><?= h($social['label']) ?></a></li><?php endif; endforeach; ?></ul></section>
        </aside>
    </div>
</section>
