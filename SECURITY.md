# Security notes

The application uses central HTML escaping, strict input normalization, CSRF tokens, a honeypot, minimum-completion time, session-based rate limiting, header-injection protection, secure session-cookie settings, a restrictive Content Security Policy and generic public errors. Email failures are logged without form bodies, credentials or message contents.

## Production checklist

- Keep `config/local.php` untracked, readable only by the deployment user and web-server group.
- Set `env` to `production`, `debug` to `false` and `display_errors=Off`.
- Force HTTPS and enable HSTS only after HTTPS is working on the subdomain.
- Keep the document root at `/var/www/skillspark/public`; never point it at the project root.
- Deny hidden files and non-public application directories at the web-server level.
- Give the web process write access only to `storage/logs` and `storage/cache`.
- Use a dedicated SMTP credential with the minimum necessary permission; rotate it if exposed.
- Keep PHP, PHPMailer, Nginx and the operating system patched without changing EdixPark’s runtime blindly.
- Review logs for repeated form abuse, but never add full submissions or credentials to logs.
- Back up the private configuration separately from the public release artifact.

Session rate limiting protects ordinary abuse but is per-session, not a distributed firewall. For sustained attacks, use Nginx rate limiting or a carefully configured edge service and test it without affecting EdixPark.

The privacy and terms drafts are operational starting points, not legal advice. Review them for Nigerian and any other applicable legal requirements before launch.
