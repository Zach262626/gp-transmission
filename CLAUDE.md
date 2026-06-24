# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## What this is

A Laravel 11 marketing + lead-capture website for **GP Transmission** (an auto transmission shop). Server-rendered Blade views styled with Bootstrap 5 (SCSS compiled via Vite), with jQuery for interactivity. It is **not** an SPA. The core business function is a customer "request service" / complaint intake form that emails the shop admins and is reviewable in an internal list.

## Commands

This project runs **either** natively (WAMP / `php`) **or** in Docker (Laravel Sail). See `README.md` for full setup. The single most common footgun: `DB_HOST` must be `127.0.0.1` for local/WAMP and `mysql` for Docker — and you must `php artisan config:clear` after changing `.env`, because cached config ignores `.env`.

```bash
# Tests (uses an isolated DB named "testing" + array mail/cache/session, see phpunit.xml)
php artisan test
php artisan test --filter=CustomerInformationControllerTest   # single test class/method
php artisan test tests/Unit/LogMailListenerTest.php           # single file

# Format / lint (Laravel Pint, PSR-12)
./vendor/bin/pint            # apply
./vendor/bin/pint --test     # check only, no changes

# Frontend assets (Vite)
npm run dev                  # dev server with HMR
npm run build                # production build

# Local app server (when not using Apache/Sail)
php artisan serve
```

Prefix any `artisan`/`npm`/`test` command with `./vendor/bin/sail` to run it inside Docker instead.

## Architecture

### Request intake flow (the heart of the app)
`POST /contact/create` → `CustomerInformationController@create` (rate-limited via `throttle:5,1`):
1. **Honeypot check**: if the hidden `website` field is filled, it's treated as a bot — the controller fakes a success redirect without saving or emailing. Keep the `website` input hidden (CSS) in the form, never collect a real value there.
2. Validates the vehicle/contact fields, then persists a `CustomerInformation` model from the **validated** subset (`CustomerInformation::create($validated)`) — so a new form field needs adding in *three* places to round-trip: the `$request->validate([...])` rules, the model's `$fillable`, and the Blade form.
3. Sends `CustomerInformationMail` (Mailgun) to `ADMIN_EMAIL`, cc `ADMIN_CC_EMAIL` (both read via `env()` with hardcoded fallbacks). Mail failure is caught and degraded to a flash warning rather than failing the request.

Admins review submissions at `GET /complaints` (`auth`-gated), rendered by `complaint_list.blade.php`.

### Mail observability
`LogMailListener` logs send attempts/successes to the dedicated `mail` log channel and emails an admin alert on failure. The two real Laravel events are wired manually in `AppServiceProvider::boot()` via `Event::listen(...)` (not auto-discovered): `MessageSending` → `handleMessageSending`, `MessageSent` → `handleMessageSent`. **Laravel dispatches no `MessageFailed` event** — send failures throw, so `handleMessageFailed()` is a plain method invoked from the `catch` block at the call site (`CustomerInformationController@create`), not an event listener.

### Auth
Session-based `web` guard plus Sanctum (`statefulApi` enabled in `bootstrap/app.php`). Registration (`AuthController@register`) is gated by a **hardcoded email allowlist** (literal address comparison inside the method — currently `zachgallant26@gmail.com` / `sebgallant@hotmail.com`); any other email is rejected. There is no public signup. Auth POST endpoints are `throttle:5,1`. The `EnsureTokenIsValid` middleware is appended globally in `bootstrap/app.php` but its check is currently commented out (pass-through).

### Routing notes
All routes are in `routes/web.php` (Laravel 11 has no `RouteServiceProvider`; routes/middleware are registered in `bootstrap/app.php`). The file defines `login`/`signin`/`logout` and `complaints` **more than once** (e.g. `login`/`signin` first as view closures, then re-bound to `AuthController`; `complaints` once inside the `auth` group and again standalone with `->middleware('auth')`) — the **last** matching definition wins, so when editing auth or complaint routes check for an earlier conflicting definition rather than assuming one mapping. SEO routes `/robots.txt` and `/sitemap.xml` are generated dynamically (not static files) so the host/Sitemap URL is correct on any domain.

### Frontend build
Vite entry points are declared in `vite.config.js`: `resources/scss/app.scss` and `resources/js/app.js`. SCSS lives under `resources/scss/` (page-specific partials in `resources/scss/pages/`). Reference compiled assets in Blade with `@vite([...])`. `@` aliases to `/resources`.

## Gotchas specific to this codebase

- **`env()` is called directly in app code** (e.g. `ADMIN_EMAIL` in `CustomerInformationController`, `LogMailListener`). These return `null` when config is cached (`config:cache`). Prefer reading through `config()` if you add new env usage.
- **Tests:** `phpunit.xml` only registers the `Unit` and `Feature` suites. `tests/Integration/` exists but is **not** run by `php artisan test` — invoke it by path if needed.
- `AppServiceProvider::boot()` sets `Schema::defaultStringLength(191)` (MySQL index-length workaround) — keep in mind when adding string columns/migrations.
- Telescope (`/telescope`) is installed for local debugging; it's disabled in the test env.
