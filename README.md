# SkillsPark Tech Hub website

A lightweight, production-oriented public website built with PHP 8.2, semantic HTML, custom CSS and vanilla JavaScript. It has no database, CMS, frontend framework or production Node.js requirement.

## Run through the XAMPP Control Panel

The current XAMPP installation already uses an EdixPark virtual host, so SkillsPark needs its own isolated local hostname.

1. Add the contents of `xampp-skillspark-vhost.conf` to `C:\xampp\apache\conf\extra\httpd-vhosts.conf`.
2. Add `127.0.0.1 skillspark.local` to `C:\Windows\System32\drivers\etc\hosts` using an Administrator editor.
3. Restart Apache from the XAMPP Control Panel.
4. Open `http://skillspark.local`.

MySQL is not required for SkillsPark.

## Alternative local server

```bash
cp config/local.example.php config/local.php
php -S 127.0.0.1:8000 server.php
```

On this Windows/XAMPP workspace, use:

```powershell
Copy-Item config/local.example.php config/local.php
C:\xampp\php\php.exe -S 127.0.0.1:8000 server.php
```

For this alternative, temporarily set `base_url` to `http://127.0.0.1:8000` in `config/local.php`, then open `http://127.0.0.1:8000`.

PHPMailer is the only optional runtime package:

```bash
composer install --no-dev --optimize-autoloader
```

Without configured SMTP, pages remain usable and the forms clearly disable submission. Add verified contact alternatives at the same time as SMTP.

## Quality checks

```powershell
C:\xampp\php\php.exe scripts\validate.php
C:\xampp\php\php.exe tests\smoke.php http://127.0.0.1:8000
C:\xampp\php\php.exe tests\forms.php http://127.0.0.1:8000
```

Run `tests/forms.php` only in a local environment with SMTP disabled; it intentionally submits security test data.

Validate all PHP files:

```powershell
$php='C:\xampp\php\php.exe'; rg --files -g '*.php' | ForEach-Object { & $php -l $_ }
```

## Key locations

- `app/content/`: editable public content
- `app/views/`: layouts, components and page presentation
- `public/assets/`: browser-served brand, image, icon, CSS and JavaScript assets
- `config/local.php`: private environment and SMTP configuration; ignored by Git
- `scripts/validate.php`: content and asset validation
- `tests/smoke.php`: route, asset, 404 and CSRF smoke tests
- `CONTENT_GUIDE.md`: exact content-editing examples
- `DEPLOYMENT.md`: isolated VPS deployment and rollback instructions

## Official logo and media

No official logo or company photographs were present in the supplied attachment folder during implementation. The current SVG wordmark and abstract compositions are explicitly fallback assets, not representations of real activity. Replace them using the paths documented in `CONTENT_GUIDE.md` after the source logo and approved media are supplied.
