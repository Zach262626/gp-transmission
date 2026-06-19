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
`POST /contact/create` → `CustomerInformationController@create`:
1. Validates the vehicle/contact fields.
2. Persists a `CustomerInformation` model (mass-assigned from `$request->all()` — keep the model's `$fillable` in sync with the form fields).
3. Sends `CustomerInformationMail` (Mailgun) to `ADMIN_EMAIL`, cc `ADMIN_CC_EMAIL`. Mail failure is caught and degraded to a flash warning rather than failing the request.

Admins review submissions at `GET /complaints` (`auth`-gated), rendered by `complaint_list.blade.php`.

### Mail observability
`LogMailListener` logs every send attempt/success/failure to the dedicated `mail` log channel and emails an admin alert on failure. It is wired manually in `AppServiceProvider::boot()` via `Event::listen(...)` (not auto-discovered). Note: this wiring currently registers all three handlers against `MessageSending` — when touching mail logging, verify the listener is bound to the intended `MessageSending` / `MessageSent` / `MessageFailed` events.

### Auth
Session-based `web` guard plus Sanctum (`statefulApi` enabled in `bootstrap/app.php`). Registration (`AuthController@register`) is gated by a **hardcoded email allowlist** — only specific addresses may create accounts. There is no public signup. The `EnsureTokenIsValid` middleware is appended globally in `bootstrap/app.php` but its check is currently commented out (pass-through).

### Routing notes
All routes are in `routes/web.php` (Laravel 11 has no `RouteServiceProvider`; routes/middleware are registered in `bootstrap/app.php`). The file contains some duplicate/overlapping `login`/`signin`/`logout` and `complaints` definitions — when editing auth or complaint routes, check for an earlier conflicting definition rather than assuming one mapping.

### Frontend build
Vite entry points are declared in `vite.config.js`: `resources/scss/app.scss` and `resources/js/app.js`. SCSS lives under `resources/scss/` (page-specific partials in `resources/scss/pages/`). Reference compiled assets in Blade with `@vite([...])`. `@` aliases to `/resources`.

## Gotchas specific to this codebase

- **`env()` is called directly in app code** (e.g. `ADMIN_EMAIL` in `CustomerInformationController`, `LogMailListener`). These return `null` when config is cached (`config:cache`). Prefer reading through `config()` if you add new env usage.
- **Tests:** `phpunit.xml` only registers the `Unit` and `Feature` suites. `tests/Integration/` exists but is **not** run by `php artisan test` — invoke it by path if needed.
- `AppServiceProvider::boot()` sets `Schema::defaultStringLength(191)` (MySQL index-length workaround) — keep in mind when adding string columns/migrations.
- Telescope (`/telescope`) is installed for local debugging; it's disabled in the test env.
