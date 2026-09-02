<?php

declare(strict_types=1);

function smtp_ready(): bool
{
    return (bool) config('smtp.enabled')
        && config('smtp.host') && config('smtp.username') && config('smtp.password')
        && config('smtp.from_email') && config('smtp.recipient')
        && class_exists(\PHPMailer\PHPMailer\PHPMailer::class);
}

function send_enquiry(array $data, string $formType): bool
{
    if (!smtp_ready()) return false;
    try {
        $mail = new \PHPMailer\PHPMailer\PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = (string) config('smtp.host');
        $mail->SMTPAuth = true;
        $mail->Username = (string) config('smtp.username');
        $mail->Password = (string) config('smtp.password');
        $mail->Port = (int) config('smtp.port', 587);
        $encryption = (string) config('smtp.encryption', 'tls');
        if ($encryption !== '') $mail->SMTPSecure = $encryption;
        $mail->CharSet = 'UTF-8';
        $mail->setFrom((string) config('smtp.from_email'), (string) config('smtp.from_name'));
        $mail->addAddress((string) config('smtp.recipient'));
        $mail->addReplyTo($data['email'], $data['name']);
        $mail->Subject = 'SkillsPark website: ' . ($formType === 'consultation' ? 'consultation request' : 'contact enquiry');
        $labels = ['name' => 'Name', 'organization' => 'Organization', 'email' => 'Email', 'phone' => 'Phone', 'location' => 'Location', 'customer_type' => 'Customer type', 'service' => 'Service', 'subject' => 'Subject', 'preferred_contact' => 'Preferred contact', 'message' => 'Message', 'problem' => 'Problem'];
        $lines = [];
        foreach ($labels as $key => $label) if (!empty($data[$key])) $lines[] = $label . ': ' . $data[$key];
        $mail->Body = implode("\n\n", $lines);
        $mail->send();

        $confirmation = new \PHPMailer\PHPMailer\PHPMailer(true);
        $confirmation->isSMTP();
        $confirmation->Host = (string) config('smtp.host');
        $confirmation->SMTPAuth = true;
        $confirmation->Username = (string) config('smtp.username');
        $confirmation->Password = (string) config('smtp.password');
        $confirmation->Port = (int) config('smtp.port', 587);
        if ($encryption !== '') $confirmation->SMTPSecure = $encryption;
        $confirmation->CharSet = 'UTF-8';
        $confirmation->setFrom((string) config('smtp.from_email'), (string) config('smtp.from_name'));
        $confirmation->addAddress($data['email'], $data['name']);
        $confirmation->Subject = 'We received your SkillsPark enquiry';
        $confirmation->Body = "Hello {$data['name']},\n\nThank you for contacting SkillsPark Tech Hub. Your enquiry has been received and our team will respond through your preferred contact method.\n\nSkillsPark Tech Hub";
        $confirmation->send();
        return true;
    } catch (Throwable $exception) {
        error_log('Mail delivery failed at ' . gmdate('c') . '; type=' . get_class($exception));
        return false;
    }
}
