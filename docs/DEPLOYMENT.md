# Deploying to Namecheap (cPanel)

## How updates work (after the one-time setup below)

```
git push origin main   →   GitHub Actions runs tests   →   if green, uploads the site over SSH,
                                                            runs migrations, rebuilds caches
```

That's it: merge or push to `main` and the live site updates in ~2–3 minutes.
Watch progress in the repo's **Actions** tab. If tests fail, nothing is deployed.
You can also redeploy without a new commit: **Actions → Deploy to Namecheap → Run workflow**.

What the deploy never touches on the server: `.env`, `storage/logs`, sessions, uploaded files.

Server layout:

```
~/gp-transmission/          ← the Laravel app (uploaded by the deploy)
~/gp-transmission/.env      ← production settings (you create this once, by hand)
~/public_html  →  ~/gp-transmission/public   (symlink, so only /public is web-visible)
```

---

## One-time setup

### 1. PHP version (cPanel → *Select PHP Version*)

- Set PHP to **8.3** (8.2 minimum).
- Make sure these extensions are ticked: `pdo_mysql`, `mbstring`, `openssl`, `tokenizer`,
  `xml`, `ctype`, `fileinfo`, `curl`, `intl`, `bcmath`, `zip`.

### 2. Database (cPanel → *MySQL® Databases*)

1. Create a database, e.g. `gpweb` → cPanel names it `<cpaneluser>_gpweb`.
2. Create a user with a strong password → `<cpaneluser>_gpuser`.
3. *Add User To Database* → tick **ALL PRIVILEGES**.

Keep the full prefixed names and password for the `.env` in step 5.

### 3. SSH key for GitHub (on your PC)

Namecheap shared hosting uses SSH port **21098**. In Git Bash:

```bash
ssh-keygen -t ed25519 -f ~/.ssh/gp_deploy -C "github-deploy" -N ""
cat ~/.ssh/gp_deploy.pub     # copy this
```

In cPanel → *SSH Access* → *Manage SSH Keys* → **Import Key**: give it a name, paste the
**public** key, import. Then back in the list click **Manage → Authorize**.

Test it (host/username are on the cPanel home page sidebar, or in your Namecheap welcome email):

```bash
ssh -i ~/.ssh/gp_deploy -p 21098 CPANELUSER@SERVER_HOST
php -v        # must say 8.2+ ; if not, recheck step 1
```

> If SSH is refused, open a Namecheap support chat and ask them to enable SSH for your account.

### 4. GitHub secrets

GitHub repo → *Settings → Secrets and variables → Actions → New repository secret*:

| Name              | Value                                                     |
|-------------------|-----------------------------------------------------------|
| `SSH_HOST`        | server hostname/IP (same as the `ssh` test above)         |
| `SSH_PORT`        | `21098`                                                   |
| `SSH_USER`        | your cPanel username                                      |
| `SSH_PRIVATE_KEY` | full contents of `~/.ssh/gp_deploy` (the file **without** `.pub`) |

### 5. Production `.env` on the server

Generate an app key on your PC: `php artisan key:generate --show` (copy the `base64:...` output).

Over SSH:

```bash
mkdir -p ~/gp-transmission && nano ~/gp-transmission/.env
```

Paste and fill in:

```dotenv
APP_NAME="GP Transmission"
APP_ENV=production
APP_KEY=base64:PASTE_KEY_HERE
APP_DEBUG=false
APP_TIMEZONE=America/Toronto
APP_URL=https://gptransmission.ca

LOG_CHANNEL=stack
LOG_STACK=single
LOG_LEVEL=warning

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=cpaneluser_gpweb
DB_USERNAME=cpaneluser_gpuser
DB_PASSWORD="the-db-password"

SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_SECURE_COOKIE=true
CACHE_STORE=database
QUEUE_CONNECTION=sync
FILESYSTEM_DISK=local

MAIL_MAILER=mailgun
MAIL_FROM_ADDRESS="requestservice@mail.gptransmission.ca"
MAIL_FROM_NAME="Request Service"
MAIL_LOG_CHANNEL=mail
MAILGUN_DOMAIN=mail.gptransmission.ca
MAILGUN_SECRET=your-mailgun-api-key
MAILGUN_ENDPOINT=api.mailgun.net

ADMIN_EMAIL=sebgallant@hotmail.com
ADMIN_CC_EMAIL=hatrickzach@gmail.com

TELESCOPE_ENABLED=false
```

Then `chmod 600 ~/gp-transmission/.env`. Save with `Ctrl+O`, `Enter`, `Ctrl+X`.

Whenever you change `.env` later, run `cd ~/gp-transmission && php artisan optimize` so the
cached config picks it up.

### 6. First deploy

Merge this branch into `main` and push (or *Actions → Deploy to Namecheap → Run workflow*).
Wait for both jobs (`test`, `deploy`) to go green. This uploads the app and creates the DB tables.

### 7. Point the domain at the app

Over SSH:

```bash
mv ~/public_html ~/public_html_old        # keep Namecheap's placeholder, just in case
ln -s ~/gp-transmission/public ~/public_html
```

Visit the domain — the site should load. (If the domain is an *addon* domain instead of the
main one, skip the symlink and set its Document Root to `gp-transmission/public` in
cPanel → *Domains*.)

### 8. SSL / HTTPS

Namecheap SSL certificates have to be activated and installed:

1. cPanel → **Namecheap SSL** (plugin) → pick the domain and the purchased certificate →
   it generates the CSR, validates and installs automatically. (Or: Namecheap dashboard →
   *Product List → SSL → Activate*, then install via cPanel → *SSL/TLS*.)
2. cPanel → *Domains* → turn on **Force HTTPS Redirect** for the domain.

Until the certificate is installed, `SESSION_SECURE_COOKIE=true` will break logins — set it
to `false` temporarily if you need to log in before SSL is live.

### 9. DNS for Mailgun

In Mailgun → *Sending → Domains → mail.gptransmission.ca*, copy the TXT (SPF/DKIM),
MX and CNAME records into DNS (Namecheap dashboard → *Domain List → Manage → Advanced DNS*,
or cPanel → *Zone Editor* if the domain uses Namecheap hosting nameservers).
Wait for Mailgun to show the domain as verified, then submit the contact form to test.

### 10. Admin account

Visit `https://gptransmission.ca/signin` and create an account with one of the allowlisted emails
(see `AuthController@register`), then review submissions at `/complaints`.

---

## Troubleshooting

| Symptom | Fix |
|---|---|
| 500 error on every page | SSH in, `tail -50 ~/gp-transmission/storage/logs/laravel.log` |
| Changed `.env` but nothing changed | `php artisan optimize` (config is cached in production) |
| Site stuck on "Service Unavailable" after a failed deploy | `cd ~/gp-transmission && php artisan up` |
| CSS/JS missing | Re-run the deploy; check `public/build/manifest.json` exists on the server |
| Contact form says email couldn't be sent | `tail ~/gp-transmission/storage/logs/mail*.log`; check Mailgun key/domain/DNS |
| Deploy fails at "Configure SSH" / "Permission denied" | Key not authorized in cPanel, or wrong `SSH_USER`/`SSH_PORT` secret |
