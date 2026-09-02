<?php
$isConsultation = ($formType ?? 'contact') === 'consultation';
$errors = flash('form_errors') ?? [];
$success = flash('form_success');
$disabled = !smtp_ready_for_view();
form_started_at($formType ?? 'contact');
function field_error(array $errors, string $name): string { return isset($errors[$name]) ? '<span class="field-error" id="error-' . h($name) . '">' . h($errors[$name]) . '</span>' : ''; }
?>
<div class="form-shell" id="enquiry-form">
    <?php if ($success): ?><div class="notice notice--success" role="status"><?= h($success) ?></div><?php endif; ?>
    <?php if (!empty($errors['_form'])): ?><div class="notice notice--error" role="alert"><?= h($errors['_form']) ?></div><?php endif; ?>
    <?php if ($disabled): ?><div class="notice notice--warning" role="status"><strong>Online form delivery is not configured.</strong> Use the verified direct contact options on this page. The form will activate automatically when SMTP is configured.</div><?php endif; ?>
    <form method="post" action="<?= h(url($isConsultation ? '/request-consultation' : '/contact')) ?>" novalidate>
        <input type="hidden" name="_token" value="<?= h(csrf_token()) ?>">
        <div class="honeypot" aria-hidden="true"><label>Website<input name="website" tabindex="-1" autocomplete="off"></label></div>
        <div class="form-grid">
            <div class="field"><label for="name">Name <span aria-hidden="true">*</span></label><input id="name" name="name" value="<?= old('name') ?>" autocomplete="name" required <?= isset($errors['name']) ? 'aria-invalid="true" aria-describedby="error-name"' : '' ?>><?= field_error($errors, 'name') ?></div>
            <div class="field"><label for="organization">Organization</label><input id="organization" name="organization" value="<?= old('organization') ?>" autocomplete="organization"></div>
            <div class="field"><label for="email">Email <span aria-hidden="true">*</span></label><input id="email" name="email" type="email" value="<?= old('email') ?>" autocomplete="email" required <?= isset($errors['email']) ? 'aria-invalid="true" aria-describedby="error-email"' : '' ?>><?= field_error($errors, 'email') ?></div>
            <div class="field"><label for="phone">Phone</label><input id="phone" name="phone" type="tel" value="<?= old('phone') ?>" autocomplete="tel" <?= isset($errors['phone']) ? 'aria-invalid="true" aria-describedby="error-phone"' : '' ?>><?= field_error($errors, 'phone') ?></div>
            <?php if ($isConsultation): ?>
            <div class="field"><label for="location">Location <span aria-hidden="true">*</span></label><input id="location" name="location" value="<?= old('location') ?>" autocomplete="address-level2" required><?= field_error($errors, 'location') ?></div>
            <div class="field"><label for="customer_type">Customer type <span aria-hidden="true">*</span></label><select id="customer_type" name="customer_type" required><option value="">Choose one</option><?php foreach (['Individual','School','Business','NGO','Government organization','Corporate organization','Partner','Other'] as $option): ?><option <?= old('customer_type') === h($option) ? 'selected' : '' ?>><?= h($option) ?></option><?php endforeach; ?></select><?= field_error($errors, 'customer_type') ?></div>
            <div class="field field--full"><label for="service">Service of interest <span aria-hidden="true">*</span></label><select id="service" name="service" required><option value="">Choose one</option><?php foreach (published(content('services')) as $service): ?><option value="<?= h($service['title']) ?>" <?= old('service') === h($service['title']) ? 'selected' : '' ?>><?= h($service['title']) ?></option><?php endforeach; ?><option <?= old('service') === 'Training' ? 'selected' : '' ?>>Training</option><option <?= old('service') === 'EdixPark' ? 'selected' : '' ?>>EdixPark</option></select><?= field_error($errors, 'service') ?></div>
            <div class="field field--full"><label for="problem">Problem or opportunity <span aria-hidden="true">*</span></label><textarea id="problem" name="problem" rows="6" required><?= old('problem') ?></textarea><?= field_error($errors, 'problem') ?></div>
            <?php else: ?>
            <div class="field field--full"><label for="subject">Subject <span aria-hidden="true">*</span></label><input id="subject" name="subject" value="<?= old('subject') ?>" required><?= field_error($errors, 'subject') ?></div>
            <div class="field field--full"><label for="message">Message <span aria-hidden="true">*</span></label><textarea id="message" name="message" rows="6" required><?= old('message') ?></textarea><?= field_error($errors, 'message') ?></div>
            <?php endif; ?>
            <fieldset class="field field--full"><legend>Preferred contact method <span aria-hidden="true">*</span></legend><div class="choice-row"><?php foreach (['Email','Phone','WhatsApp'] as $option): ?><label><input type="radio" name="preferred_contact" value="<?= h($option) ?>" <?= old('preferred_contact') === h($option) ? 'checked' : '' ?> required> <?= h($option) ?></label><?php endforeach; ?></div><?= field_error($errors, 'preferred_contact') ?></fieldset>
            <div class="field field--full checkbox-field"><label><input type="checkbox" name="consent" value="yes" <?= old('consent') === 'yes' ? 'checked' : '' ?> required> I consent to SkillsPark using these details to respond to my enquiry.</label><?= field_error($errors, 'consent') ?></div>
        </div>
        <button class="button" type="submit" <?= $disabled ? 'disabled aria-disabled="true"' : '' ?>><?= $isConsultation ? 'Send Consultation Request' : 'Send Enquiry' ?></button>
    </form>
</div>
