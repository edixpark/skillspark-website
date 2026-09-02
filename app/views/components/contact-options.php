<?php $contact = config('contact', []); ?>
<aside class="contact-options card">
    <p class="eyebrow">Direct contact</p><h2>Prefer another channel?</h2>
    <?php if (empty($contact['email']) && empty($contact['phone']) && empty($contact['whatsapp'])): ?><p>Direct contact details are being configured. Form submission is disabled until verified contact and SMTP settings are added.</p><?php endif; ?>
    <ul>
        <?php if (!empty($contact['email'])): ?><li><?= icon('mail') ?><span><strong>Email</strong><a href="mailto:<?= h($contact['email']) ?>"><?= h($contact['email']) ?></a></span></li><?php endif; ?>
        <?php if (!empty($contact['phone'])): ?><li><?= icon('phone') ?><span><strong>Phone</strong><a href="tel:<?= h(preg_replace('/[^+0-9]/', '', $contact['phone'])) ?>"><?= h($contact['phone']) ?></a></span></li><?php endif; ?>
        <?php if (!empty($contact['whatsapp'])): ?><li><?= icon('chat') ?><span><strong>WhatsApp</strong><a href="https://wa.me/<?= h(preg_replace('/\D/', '', $contact['whatsapp'])) ?>" rel="noopener">Chat with SkillsPark</a></span></li><?php endif; ?>
    </ul>
    <p><strong>Hours</strong><br><?= h($contact['hours'] ?? '') ?></p>
</aside>
