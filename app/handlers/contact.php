<?php

declare(strict_types=1);

function handle_form(string $formType): never
{
    $target = $formType === 'consultation' ? '/request-consultation' : '/contact';
    $started = form_started_at($formType);
    $errors = [];

    if (!csrf_valid($_POST['_token'] ?? null)) $errors['_form'] = 'Your session expired. Refresh the page and try again.';
    if (!isset($errors['_form']) && !empty($_POST['website'] ?? '')) $errors['_form'] = 'We could not process this request.';
    $withinRateLimit = rate_limit_allows($formType);
    if (!isset($errors['_form']) && !$withinRateLimit) $errors['_form'] = 'Too many attempts. Please wait before trying again.';
    if (!isset($errors['_form']) && time() - $started < (int) config('forms.minimum_seconds', 3)) $errors['_form'] = 'Please take a moment to review the form before sending.';

    $data = [
        'name' => clean_line($_POST['name'] ?? ''),
        'organization' => clean_line($_POST['organization'] ?? ''),
        'email' => clean_line($_POST['email'] ?? ''),
        'phone' => clean_line($_POST['phone'] ?? '', 40),
        'preferred_contact' => clean_line($_POST['preferred_contact'] ?? '', 30),
    ];
    if (mb_strlen($data['name']) < 2) $errors['name'] = 'Enter your name.';
    if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) $errors['email'] = 'Enter a valid email address.';
    if ($data['phone'] !== '' && !preg_match('/^[+0-9() .-]{7,30}$/', $data['phone'])) $errors['phone'] = 'Enter a valid phone number.';
    if (!in_array($data['preferred_contact'], ['Email', 'Phone', 'WhatsApp'], true)) $errors['preferred_contact'] = 'Choose a preferred contact method.';
    if (($_POST['consent'] ?? '') !== 'yes') $errors['consent'] = 'Consent is required so we can respond.';

    if ($formType === 'consultation') {
        $data += ['location' => clean_line($_POST['location'] ?? ''), 'customer_type' => clean_line($_POST['customer_type'] ?? ''), 'service' => clean_line($_POST['service'] ?? ''), 'problem' => clean_text($_POST['problem'] ?? '')];
        $customerTypes = ['Individual', 'School', 'Business', 'NGO', 'Government organization', 'Corporate organization', 'Partner', 'Other'];
        if ($data['location'] === '') $errors['location'] = 'Enter your location.';
        if (!in_array($data['customer_type'], $customerTypes, true)) $errors['customer_type'] = 'Choose a customer type.';
        if ($data['service'] === '') $errors['service'] = 'Choose a service.';
        if (mb_strlen($data['problem']) < 20) $errors['problem'] = 'Tell us a little more about the problem or opportunity.';
    } else {
        $data += ['subject' => clean_line($_POST['subject'] ?? ''), 'message' => clean_text($_POST['message'] ?? '')];
        if (mb_strlen($data['subject']) < 3) $errors['subject'] = 'Enter a subject.';
        if (mb_strlen($data['message']) < 20) $errors['message'] = 'Enter a message of at least 20 characters.';
    }

    $_SESSION['form_old'] = array_map('strval', $_POST);
    if ($errors) {
        flash('form_errors', $errors);
        redirect($target . '#enquiry-form');
    }
    require ROOT_PATH . '/app/mailer.php';
    if (!send_enquiry($data, $formType)) {
        flash('form_errors', ['_form' => 'Email delivery is not available right now. Please use the contact alternatives shown on this page.']);
        redirect($target . '#enquiry-form');
    }
    unset($_SESSION['form_old'], $_SESSION['started_' . $formType]);
    flash('form_success', 'Thank you. Your enquiry was sent successfully, and a confirmation has been emailed to you.');
    redirect($target . '#enquiry-form');
}
