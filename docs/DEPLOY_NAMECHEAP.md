# Deploying to Namecheap (cPanel shared hosting): the easy, manual way

You'll upload one zip through cPanel, fill in one settings file, and run a few
commands in cPanel's built-in Terminal. You don't need Git, SSH keys, Composer
or Node on the server. Expect about an hour. DNS and SSL can take a few hours
to take effect.

**How it fits together**

```
/home/<cpaneluser>/gp-transmission/          <- the whole Laravel app (private)
/home/<cpaneluser>/gp-transmission/public/   <- the only folder the web may see
/home/<cpaneluser>/public_html  ->  link to gp-transmission/public
```

> Never put the whole app *inside* `public_html`. That would make `.env`
> (passwords, API keys) downloadable.

---

## Step 0: Build the upload zip (on your PC)

`dist/gp-transmission.zip` is the file you upload. It contains the app with
production-only PHP packages (`vendor/`) and compiled CSS/JS (`public/build/`).
It does **not** contain `.env`, tests or Docker files.

To rebuild it after code changes:

1. `npm run build`
2. Copy the project to a clean folder **without** `node_modules`, `tests`, `.git`, `.env`.
3. In that copy run `php composer.phar install --no-dev --optimize-autoloader`.
4. Zip the folder so the zip contains a single top-level `gp-transmission/` folder.

Also have ready:
- Your cPanel login (Namecheap → **Dashboard → Hosting List → Go to cPanel**).

Emails are sent through a mailbox that comes free with your hosting, so you
don't need Mailgun, another domain or another certificate.

---

## Step 1: Point the domain at the hosting (DNS)

1. Namecheap → **Domain List** → **Manage** next to your domain.
2. **Nameservers** → **Namecheap Web Hosting DNS** → ✓ save.
   (If you bought the domain together with the hosting this is often already set.)
3. This takes anywhere from minutes to 24-48 h. Check at <https://dnschecker.org>.

> With hosting DNS, the email records (MX, SPF, DKIM) are created for you
> automatically. From now on, edit DNS in **cPanel → Zone Editor**, not
> Namecheap's *Advanced DNS* tab.

---

## Step 2: Set PHP to 8.3

1. cPanel → **Select PHP Version** (in *Software*).
2. **Current PHP version** → **8.3** → **Set as current**.
3. **Extensions** tab: make sure these are ticked:
   `bcmath, ctype, curl, dom, fileinfo, intl, mbstring, mysqlnd, openssl, pdo, pdo_mysql, tokenizer, xml, zip`.
4. **Options** tab (optional): `memory_limit` → `256M`.

---

## Step 3: Create the database

1. cPanel → **MySQL® Database Wizard**.
2. Database name `gpweb`. cPanel saves it as `<cpaneluser>_gpweb`. **Write the full name down.**
3. Username `gpuser` (saved as `<cpaneluser>_gpuser`). Click **Password Generator**, then **copy and save the password**.
4. Tick **ALL PRIVILEGES** → **Next Step**.

---

## Step 3b: Create the mailbox the site sends from

1. cPanel → **Email Accounts** → **+ Create**.
2. Username `requestservice` (so the address is `requestservice@gptransmission.ca`). Click **Generate** for a password and **save it**. Storage can stay at the default. **Create**.
3. Next to the new account, click **Connect Devices**. Under **Secure SSL/TLS Settings**, write down the **Outgoing Server** (often something like `serverXX.web-hosting.com`) and the **SMTP Port** (should be `465`).
4. Recommended: cPanel → **Email Deliverability** → if your domain shows a problem, click **Repair** on it. This sets up SPF and DKIM so the emails are less likely to end up in spam.

---

## Step 4: Upload and extract the app

1. cPanel → **File Manager**. It opens your home folder (`/home/<cpaneluser>`), the one that *contains* `public_html`. Stay here; don't go into `public_html`.
2. **Upload** → choose `dist/gp-transmission.zip` → wait for 100% → **Go Back**.
3. Right-click `gp-transmission.zip` → **Extract** → extract to `/home/<cpaneluser>` → **Extract Files**.
4. You should now have a `gp-transmission` folder next to `public_html`. Delete the zip.

---

## Step 5: Create the `.env` settings file

1. In File Manager, top-right **Settings** → tick **Show Hidden Files (dotfiles)** → Save.
2. Open `gp-transmission`, right-click `.env.production.example` → **Copy** → name the copy `/home/<cpaneluser>/gp-transmission/.env`.
3. Right-click `.env` → **Edit** and fill in every `<...>` value:

| Key | What to put |
|---|---|
| `APP_URL` | `https://yourdomain` (e.g. `https://gptransmission.ca`) |
| `DB_DATABASE` / `DB_USERNAME` / `DB_PASSWORD` | from Step 3, **with** the `<cpaneluser>_` prefix |
| `MAIL_HOST` | the **Outgoing Server** from Step 3b |
| `MAIL_PORT` | `465` |
| `MAIL_USERNAME` / `MAIL_FROM_ADDRESS` | the mailbox address, e.g. `requestservice@gptransmission.ca` |
| `MAIL_PASSWORD` | that mailbox's password from Step 3b |
| `ADMIN_EMAIL` / `ADMIN_CC_EMAIL` | the inboxes that should get service requests |

Leave `APP_KEY=` empty for now. Leave `DB_HOST=localhost`. **Save Changes**.

4. Right-click `.env` → **Change Permissions** → `600` (owner read/write only).

---

## Step 6: Run the setup commands (cPanel Terminal)

cPanel → **Terminal** (in *Advanced*). Accept the warning. Paste these one at a time:

```bash
cd ~/gp-transmission
```

```bash
php -v
```

It must say **8.3**. If it shows an older version, use
`/opt/alt/php83/usr/bin/php` instead of `php` in every command below.

```bash
php artisan key:generate --force
```

```bash
php artisan migrate --force
```

This creates the tables. If it says `Access denied`, recheck the DB values in `.env` (Step 5).

```bash
php artisan config:cache && php artisan route:cache && php artisan view:cache
```

> **Rule to remember:** after *any* later edit to `.env`, re-run
> `php artisan config:cache`, otherwise the site keeps using the old values.

---

## Step 7: Point the website at `public/`

Still in Terminal. This keeps your old `public_html` as a backup and replaces
it with a link to the app's `public` folder:

```bash
cd ~ && mv public_html public_html_backup && ln -s ~/gp-transmission/public ~/public_html
```

```bash
ls -la ~ | grep public_html
```

You should see `public_html -> /home/<cpaneluser>/gp-transmission/public`.
Open `http://yourdomain`. The homepage should load.

> **Addon domain instead of the main domain?** Skip the link. Go to cPanel →
> **Domains** → **Manage** → set **Document Root** to `gp-transmission/public`.

---

## Step 8: Install SSL and force HTTPS

1. cPanel → **Namecheap SSL** (in *Security*). Find your domain → **Install**. It validates and installs by itself (up to ~30 min). DNS from Step 1 must be working first.
   - *Bought the certificate separately and it isn't listed?* Namecheap → **Product List → SSL Certificates → Activate**, generate the CSR in cPanel → **SSL/TLS → Generate CSR**, validate, then paste the issued cert in **SSL/TLS → Manage SSL sites**.
2. cPanel → **Domains** → turn **Force HTTPS Redirect** **On**.
3. Open `https://yourdomain` and check for the padlock.

Login only works over **https** (`SESSION_SECURE_COOKIE=true`). That's intended.

---

## Step 9: Test the contact form email

1. Submit a test at `https://yourdomain/contact`.
2. Check that it arrives at `ADMIN_EMAIL`. **Check the spam folder too.** If it landed there, mark it *Not spam* so future ones come through.
3. If the page says the email *could not be sent*, look at the logs in File Manager: `gp-transmission/storage/logs/` (`mail-*.log`, `laravel-*.log`). Usually the cause is a wrong `MAIL_HOST` or `MAIL_PASSWORD`. Fix `.env`, then run `php artisan config:cache`.

---

## Step 10: Create your admin login

1. Go to `https://yourdomain/signin` and register with an allow-listed email (hard-coded in `AuthController@register`).
2. Log in at `/login` → open `/complaints`. Your test request from Step 9 should be listed.

---

## Final checklist

- [ ] `https://yourdomain` and `https://www.yourdomain` load with a padlock
- [ ] `http://` redirects to `https://`
- [ ] Contact form submits and the email arrives
- [ ] `/complaints` works after login
- [ ] `https://yourdomain/.env` gives **404** (proves the app is private)
- [ ] `/robots.txt` and `/sitemap.xml` show `https://yourdomain`
- [ ] Once happy, delete `public_html_backup` in File Manager

---

## Updating the site later (manual)

1. On your PC, rebuild the zip (Step 0).
2. In File Manager, upload it to the home folder and extract it. Choose to **overwrite** existing files. Your `.env` and `storage/` logs are not in the zip, so they're kept.
3. In Terminal:

   ```bash
   cd ~/gp-transmission && php artisan migrate --force && php artisan config:cache && php artisan route:cache && php artisan view:cache
   ```

(Later you can switch to the Git + `deploy.sh` flow for one-command updates.)

---

## Troubleshooting

| Symptom | Fix |
|---|---|
| 500 error / blank page | Read `gp-transmission/storage/logs/laravel-*.log`. Temporarily set `APP_DEBUG=true`, run `php artisan config:cache`, reload, then **set it back to false**. |
| Edited `.env` but nothing changed | `php artisan config:cache` |
| `Access denied for user` | DB name/user need the `<cpaneluser>_` prefix, and the user needs ALL PRIVILEGES on the DB (Step 3). |
| `could not find driver` | Tick `pdo_mysql` in Select PHP Version → Extensions. |
| `No application encryption key` | Run `php artisan key:generate --force` then `php artisan config:cache`. |
| Page loads with no styling | `gp-transmission/public/build/` is missing. Re-upload the zip. |
| Login keeps returning to the login page | You're on `http://`. Finish Step 8. |
| Old Namecheap placeholder page still shows | DNS not propagated yet, or Step 7 didn't run. Check `ls -la ~ \| grep public_html`. |
| Email log says `authentication failed` | `MAIL_USERNAME` must be the full address. Reset the mailbox password in cPanel → Email Accounts, put it in `.env`, run `php artisan config:cache`. |
| Email log says `Connection refused` / timed out | Use the exact **Outgoing Server** from Connect Devices and port `465`. |
| Wrong PHP version in Terminal | Use `/opt/alt/php83/usr/bin/php` instead of `php`. |
