<?php

declare(strict_types=1);

$base = rtrim($argv[1] ?? 'http://127.0.0.1:8000', '/');
$failures = [];

function browser_session(): string
{
    $file = tempnam(sys_get_temp_dir(), 'skillspark-test-');
    if ($file === false) throw new RuntimeException('Could not create test cookie jar.');
    return $file;
}

function http_call(string $url, string $jar, array $post = []): array
{
    $headers = [];
    $handle = curl_init($url);
    curl_setopt_array($handle, [
        CURLOPT_RETURNTRANSFER => true, CURLOPT_FOLLOWLOCATION => false,
        CURLOPT_COOKIEJAR => $jar, CURLOPT_COOKIEFILE => $jar,
        CURLOPT_TIMEOUT => 10,
        CURLOPT_HEADERFUNCTION => static function ($curl, string $line) use (&$headers): int { $headers[] = trim($line); return strlen($line); },
    ]);
    if ($post) curl_setopt_array($handle, [CURLOPT_POST => true, CURLOPT_POSTFIELDS => http_build_query($post)]);
    $body = (string) curl_exec($handle);
    $status = (int) curl_getinfo($handle, CURLINFO_RESPONSE_CODE);
    curl_close($handle);
    return [$status, $body, $headers];
}

function token_from(string $html): string
{
    preg_match('/name="_token" value="([a-f0-9]{64})"/', $html, $match);
    return $match[1] ?? '';
}

function follow_form(string $base, string $jar, array $data, string $path = '/contact'): string
{
    [$status] = http_call($base . $path, $jar, $data);
    if ($status !== 303) throw new RuntimeException("POST {$path} returned {$status}, expected 303.");
    [, $page] = http_call($base . $path, $jar);
    return $page;
}

// CSRF rejection.
$jar = browser_session();
[, $page] = http_call($base . '/contact', $jar);
$result = follow_form($base, $jar, ['name'=>'Test User','email'=>'test@example.com','subject'=>'Question','message'=>str_repeat('Message ',5),'preferred_contact'=>'Email','consent'=>'yes']);
if (!str_contains($result, 'Your session expired')) $failures[] = 'CSRF rejection message was not shown.';
@unlink($jar);

// Time-based bot protection.
$jar = browser_session();
[, $page] = http_call($base . '/contact', $jar); $token = token_from($page);
$result = follow_form($base, $jar, ['_token'=>$token,'name'=>'Test User','email'=>'test@example.com','subject'=>'Question','message'=>str_repeat('Message ',5),'preferred_contact'=>'Email','consent'=>'yes']);
if (!str_contains($result, 'take a moment')) $failures[] = 'Minimum completion-time protection did not trigger.';
@unlink($jar);

// Honeypot after the minimum time.
$jar = browser_session();
[, $page] = http_call($base . '/request-consultation', $jar); $token = token_from($page); sleep(4);
$result = follow_form($base, $jar, ['_token'=>$token,'website'=>'spam.example','name'=>'Test User','email'=>'test@example.com','location'=>'Abuja','customer_type'=>'Business','service'=>'Training','problem'=>str_repeat('A useful description. ',3),'preferred_contact'=>'Email','consent'=>'yes'], '/request-consultation');
if (!str_contains($result, 'could not process')) $failures[] = 'Honeypot protection did not trigger.';
@unlink($jar);

// Field validation and safe value preservation.
$jar = browser_session();
[, $page] = http_call($base . '/contact', $jar); $token = token_from($page); sleep(4);
$result = follow_form($base, $jar, ['_token'=>$token,'name'=>'','organization'=>'Safe Organization','email'=>'bad-email','phone'=>'not-a-phone','subject'=>'x','message'=>'short','preferred_contact'=>'','consent'=>'']);
foreach (['Enter your name.','Enter a valid email address.','Enter a valid phone number.','Enter a subject.','Enter a message of at least 20 characters.','Choose a preferred contact method.','Consent is required'] as $message) if (!str_contains($result, $message)) $failures[] = "Validation message missing: {$message}";
if (!str_contains($result, 'value="Safe Organization"')) $failures[] = 'Safe form values were not preserved.';
@unlink($jar);

// SMTP-disabled submissions must never show false success.
$jar = browser_session();
[, $page] = http_call($base . '/contact', $jar); $token = token_from($page); sleep(4);
$result = follow_form($base, $jar, ['_token'=>$token,'name'=>'Delivery Test','organization'=>'Test Organization','email'=>'test@example.com','phone'=>'+234 800 000 0000','subject'=>'Delivery question','message'=>str_repeat('A complete test message. ',3),'preferred_contact'=>'Email','consent'=>'yes']);
if (!str_contains($result, 'Email delivery is not available')) $failures[] = 'SMTP-disabled submission did not fail safely.';
if (str_contains($result, 'sent successfully')) $failures[] = 'SMTP-disabled submission displayed false success.';
@unlink($jar);

// Rate limit; each rejected attempt still counts.
$jar = browser_session();
[, $page] = http_call($base . '/contact', $jar); $token = token_from($page);
for ($i = 0; $i < 5; $i++) $result = follow_form($base, $jar, ['_token'=>$token,'name'=>'Rate Test','email'=>'test@example.com','subject'=>'Question','message'=>str_repeat('Message ',5),'preferred_contact'=>'Email','consent'=>'yes']);
if (!str_contains($result, 'Too many attempts')) $failures[] = 'Session rate limit did not trigger.';
@unlink($jar);

echo $failures ? "FAILURES\n- " . implode("\n- ", $failures) . "\n" : "Form security tests passed.\n";
exit($failures ? 1 : 0);
