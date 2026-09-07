<?php
$contact = config('contact', []);
$directMessage = ($formType ?? '') === 'consultation'
    ? 'Hello SkillsPark, I would like to request a consultation.'
    : 'Hello SkillsPark, I would like to make an enquiry.';
$directWhatsApp = whatsapp_url($directMessage);
?>
<aside class="contact-options card">
    <p class="eyebrow">Direct contact</p>
    <h2>Prefer to contact us directly?</h2>
    <ul>
        <li><?= icon('chat') ?><span><strong>WhatsApp</strong><a href="<?= h($directWhatsApp) ?>" target="_blank" rel="noopener noreferrer" aria-label="Chat with SkillsPark on WhatsApp (opens in a new tab)">Chat with SkillsPark</a></span></li>
        <li><?= icon('phone') ?><span><strong>Call</strong><a href="<?= h($contact['phone_uri']) ?>"><?= h($contact['phone']) ?></a></span></li>
        <li><?= icon('mail') ?><span><strong>Email</strong><a class="wrap-link" href="<?= h($contact['email_uri']) ?>"><?= h($contact['email']) ?></a></span></li>
    </ul>
    <p class="contact-note">If online form delivery is unavailable, these verified channels remain available.</p>
</aside>
