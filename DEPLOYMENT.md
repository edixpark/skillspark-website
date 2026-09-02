# Isolated SkillsPark VPS deployment

This procedure creates a separate `/var/www/skillspark` release and Nginx server block. It does not require moving, restarting, modifying or sharing EdixPark application files, databases, credentials or configuration. Run commands deliberately on the VPS; none are executed automatically by this project.

## 1. Inspect the VPS before changing it

Record the current state and identify the web stack used by EdixPark without editing it:

```bash
uname -a
cat /etc/os-release
nginx -v 2>&1 || true
apache2 -v 2>&1 || true
php -v
php --ini
ls -la /run/php/
systemctl --no-pager --type=service | grep -E 'nginx|apache|php.*fpm'
composer --version || true
sudo nginx -T > "$HOME/nginx-before-skillspark.txt" 2>&1
```

The `ls /run/php/` output identifies the available PHP-FPM socket. Check that its version supports PHP 8.2 code. Do not replace system PHP, change EdixPark’s pool, alter its `php.ini`, or enable modules globally just for SkillsPark. If a distinct PHP version is required, create a separate FPM pool or ask the server administrator to do so.

## 2. Prepare DNS

In the authoritative DNS provider, create an `A` record:

- Host/name: `skillspark`
- Value: the VPS public IPv4 address
- TTL: provider default or a low temporary deployment TTL

Add an `AAAA` record only if IPv6 is correctly routed to the VPS. Verify with `dig +short skillspark.edixpark.com A` (and `AAAA` where applicable).

## 3. Create the isolated directory

```bash
sudo install -d -o "$USER" -g www-data -m 0750 /var/www/skillspark
```

Upload the project with Git, SFTP or `rsync`. A safe release pattern is:

```bash
sudo install -d -o "$USER" -g www-data -m 0750 /var/www/skillspark/releases
release="$(date +%Y%m%d%H%M%S)"
mkdir "/var/www/skillspark/releases/$release"
# Upload or clone only this SkillsPark repository into that release directory.
```

For a simpler first deployment, upload directly to `/var/www/skillspark`, ensuring that `/var/www/skillspark/public/index.php` exists. Do not use an EdixPark directory as a parent or target.

## 4. Install the optional mail dependency

From the SkillsPark release directory:

```bash
cd /var/www/skillspark
composer install --no-dev --prefer-dist --optimize-autoloader
```

PHPMailer is the only Composer production dependency. The public site renders without it, but form submission stays disabled until PHPMailer and SMTP are ready.

## 5. Configure private settings

```bash
cp config/local.example.php config/local.php
nano config/local.php
```

Set:

- `env` to `production`
- `debug` to `false`
- `base_url` to `https://skillspark.edixpark.com`
- verified contact email, phone and WhatsApp number
- verified SMTP host, port, encryption, username, password, from address and recipient

Use a dedicated SMTP credential. Test the sender domain’s SPF, DKIM and DMARC configuration. Never place secrets in `public/`, Git, a web-server file or documentation.

## 6. Validate before web-server activation

Use the intended PHP binary explicitly if several are installed:

```bash
cd /var/www/skillspark
php scripts/validate.php
find app config public scripts tests -name '*.php' -print0 | xargs -0 -n1 php -l
```

Warnings about founder content are expected until that information is supplied. Contact/SMTP warnings must be resolved before expecting functional forms.

## 7. Ownership and permissions

Keep code non-writable by the web process. Allow writes only where runtime logs/cache need them:

```bash
sudo chown -R "$USER":www-data /var/www/skillspark
sudo find /var/www/skillspark -type d -exec chmod 0750 {} \;
sudo find /var/www/skillspark -type f -exec chmod 0640 {} \;
sudo chmod 0755 /var/www/skillspark/public
sudo find /var/www/skillspark/public -type d -exec chmod 0755 {} \;
sudo find /var/www/skillspark/public -type f -exec chmod 0644 {} \;
sudo chmod 0770 /var/www/skillspark/storage/logs /var/www/skillspark/storage/cache
sudo chmod 0640 /var/www/skillspark/config/local.php
```

If the server uses a group other than `www-data`, substitute the inspected PHP-FPM/web-server group. Do not change EdixPark ownership recursively.

## 8. Configure a separate Nginx server block

Copy the supplied config and adjust only the PHP socket after inspection:

```bash
sudo cp /var/www/skillspark/nginx-skillspark.conf /etc/nginx/sites-available/skillspark.edixpark.com
sudo nano /etc/nginx/sites-available/skillspark.edixpark.com
sudo ln -s /etc/nginx/sites-available/skillspark.edixpark.com /etc/nginx/sites-enabled/skillspark.edixpark.com
```

Confirm:

- `server_name skillspark.edixpark.com`
- `root /var/www/skillspark/public`
- the exact existing or dedicated PHP-FPM socket, such as `/run/php/php8.2-fpm.sock`

Do not edit the EdixPark server block. Test the complete Nginx configuration before reload:

```bash
sudo nginx -t
```

Only after a successful test:

```bash
sudo systemctl reload nginx
```

Reloading Nginx applies validated configuration without restarting EdixPark. If Nginx testing fails, remove or correct only the new SkillsPark symlink/config and test again.

## 9. Optional Apache setup

If inspection shows Apache rather than Nginx, review `apache-skillspark.conf`, confirm the PHP 8.2 handler/FPM arrangement, copy it to `sites-available`, enable the site and test before reload:

```bash
sudo cp /var/www/skillspark/apache-skillspark.conf /etc/apache2/sites-available/skillspark.edixpark.com.conf
sudo a2ensite skillspark.edixpark.com.conf
sudo apache2ctl configtest
sudo systemctl reload apache2
```

Do not enable or disable modules without checking the impact on existing sites.

## 10. Obtain HTTPS

After DNS resolves and HTTP responds:

```bash
sudo certbot --nginx -d skillspark.edixpark.com
sudo certbot renew --dry-run
```

For Apache, use `certbot --apache`. Inspect the generated block, verify HTTP-to-HTTPS redirection and then consider adding HSTS to the HTTPS block:

```nginx
add_header Strict-Transport-Security "max-age=31536000; includeSubDomains" always;
```

Use `includeSubDomains` only when every affected subdomain, including EdixPark, is permanently HTTPS-capable. Otherwise omit it.

## 11. Production PHP and performance

For the SkillsPark FPM pool or compatible production configuration, confirm:

```ini
display_errors = Off
log_errors = On
expose_php = Off
session.cookie_httponly = 1
session.cookie_secure = 1
session.cookie_samesite = Lax
```

Do not modify the global `php.ini` used by EdixPark without a tested change plan. Prefer pool-specific settings. Enable Brotli only if the current Nginx build already supports it; otherwise use `gzip on` for text, CSS, JavaScript, SVG and JSON in the relevant HTTP/server context. The supplied config sets long-lived immutable caching for versioned assets.

## 12. Test the deployed site

```bash
cd /var/www/skillspark
php tests/smoke.php https://skillspark.edixpark.com
curl -I https://skillspark.edixpark.com/
curl -I https://skillspark.edixpark.com/not-a-real-page
curl -s https://skillspark.edixpark.com/sitemap.xml | head
```

Then manually test desktop and mobile navigation, dropdowns, gallery filters/lightbox, keyboard navigation, reduced-motion mode, both forms, confirmation email, WhatsApp, every external link and browser console. Confirm the 404 is an actual 404. Test SMTP with a real controlled enquiry and inspect only private logs if delivery fails.

## 13. Backups

Back up the SkillsPark code, approved media and encrypted/private configuration separately from EdixPark:

```bash
sudo tar --exclude='vendor' --exclude='storage/logs/*.log' -czf "/var/backups/skillspark-$(date +%F-%H%M).tar.gz" /var/www/skillspark
```

Restrict backup permissions and verify restoration into a temporary directory. This site has no database.

## 14. Safe future releases

For release directories, upload and validate a new release before switching:

```bash
new_release="/var/www/skillspark/releases/YYYYMMDDHHMMSS"
cd "$new_release"
composer install --no-dev --prefer-dist --optimize-autoloader
php scripts/validate.php
php -l public/index.php
```

Copy the private `config/local.php` from the prior SkillsPark release with protected permissions, never from EdixPark. Point a `/var/www/skillspark/current` symlink to the tested release and set the Nginx root to `/var/www/skillspark/current/public` if adopting this pattern. Validate `nginx -t`, then reload.

## 15. Rollback without affecting EdixPark

Keep at least one previous SkillsPark release. To roll back, switch only the SkillsPark `current` symlink to the prior release, test Nginx and reload:

```bash
sudo ln -sfn /var/www/skillspark/releases/PREVIOUS /var/www/skillspark/current
sudo nginx -t
sudo systemctl reload nginx
```

If not using symlinks, restore the SkillsPark-only backup into `/var/www/skillspark` after first moving the failed SkillsPark release aside. Never target an EdixPark directory, database, service or credential during rollback.
