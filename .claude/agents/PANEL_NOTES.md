# Panel notes (shared scratchpad)

Append a dated section when you audit or change something. Keep it short. Flag anything
that touches another member's lane.

---

## 2026-06-22 — Round 2 audit + coordinated fix pass

All four members audited the post-P0–P2 state (see `findings_*.md`). Owner reported the
mobile page was too tall and too wordy. Applied (coordinator-integrated to avoid collisions):

- **Perf/a11y:** Hero PNG (2.83 MB) → WebP `<picture>` (49–85 KB) + width/height; the 6 card
  PNGs → WebP + a mobile `<source>` so phones don't download them (~1.76 MB saved) + dimensions;
  all `./img`/favicon paths → `asset()` (fixes broken logo/images on /services,/about,/contact);
  footer SVGs `aria-hidden`; map 📍 `aria-hidden`.
- **UX:** hero capped to `min-height:60vh` on mobile + smaller h1 (the vertical-space fix);
  added a mobile hero "Call Now" button; reserved `body` bottom padding so the sticky call
  button doesn't overlap the form submit/footer; `#main-item-7` collapsed to one line on mobile.
- **SEO:** contact page got its own title/meta (was duplicating the home title); removed the
  public `/testing` route; og fallbacks aligned with title/meta; og:image → 1200×644 share card
  + width/height/alt; JSON-LD `sameAs` now includes the Google Business Profile.
- **Brand:** form name placeholder "John Doe" → "First and last name"; richer complaint
  placeholder; footer legal-name casing aligned ("Auto Repair Inc.") with a TODO; copyright
  year dynamic; Hotmail TODO added in footer; removed dead "Make an Appointment" markup.

### Deferred (need owner input / out of scope)
- Branded email (need a real mailbox), warranty terms, owner story + real photos, live
  server-side Google reviews (Places API key), bilingual FR/EN, single CSS-only sticky nav.
- Confirm `APP_URL` is the https canonical origin so `url()` emits one canonical host.

---

## 2026-06-24 — Dependabot remediation: POSITIONS (CI/CD lane, analysis only)

Read-only inspection of the 57 alerts. No lockfiles touched (PM decides before build).
- **Production-exposure verdict:** all 35 npm alerts are `devDependencies`/build-time. Vite
  emits static assets to `public/build`; Node tooling (vite/rollup/esbuild/postcss/sass) never
  ships. EXCEPTION: `axios` is `import`ed in `resources/js/bootstrap.js:1` → bundled into the
  shipped JS (`window.axios`), so it IS the one npm pkg with real client-side surface — though
  the flagged CVEs (NO_PROXY/proxy/SSRF/follow-redirects) are Node-HTTP-adapter only and don't
  affect the browser XHR build. Treat axios as "bundled but low real risk", still bump it.
- **Composer:** only `laravel/framework` is special. Patched line is 12.60.0 but our constraint
  is `^11.9` (lock at 11.44.7) — there IS NO 11.x patch for alerts #85/#86 (CRLF email rule);
  fixing needs the 11→12 MAJOR upgrade (also bumps Sanctum 4→? / Telescope, php still ^8.2 ok).
  Flagged as needs-a-decision. Everything else (symfony/*, guzzle/*, commonmark, psr7, psysh,
  phpunit, yaml, polyfill-intl-idn) is transitive and bumps cleanly via
  `composer update <pkg> --with-all-dependencies` with NO composer.json edit.
- **Lanes:** build-output changes (vite 5→6) coordinate w/ perf-a11y; the npm-vs-prod verdict
  is the security lane's call on urgency; CI test gating is QA's. CI workflow only runs
  `npm install` + `npm run build` (no `npm ci`, no `php artisan test` step) — see findings.

---

## 2026-06-24 — Dependabot remediation: POSITIONS complete (security + backend lanes)

**Consensus reached independently across security, devops, and backend lanes.** No P0; nothing
internet-exploitable today. The honeypot, `throttle:5,1`, hardcoded mail headers, validated-subset
persistence, and absence of user-influenced URL generation neutralize the reachability of most advisories.

**Security lane (triage):**
- P1 — patch now (all in-major, low risk): `symfony/http-foundation` (request-parsing layer under
  every route), `guzzlehttp/guzzle` + `guzzlehttp/psr7` (Mailgun transport hygiene).
- P2 — low/no reachability, patch opportunistically: `symfony/mailer`+`symfony/mime` (headers
  hardcoded, no Reply-To, user data is body-only & escaped → no sink), `symfony/routing` (no
  regex-requirement route, no user-URL redirect), `league/commonmark` (not called), `polyfill-intl-idn`.
- P3 — dev-scope/CLI: `phpunit`, `symfony/yaml`, `psy/psysh`, and the whole npm dev-tooling bucket.
- `laravel/framework` (#85/#86): NOT an emergency — the `email` rule has no reachable header sink here.
- Watch-item: deferrals become live IF a future change adds Reply-To-from-user, a Markdown mailable,
  a route regex requirement, or an open redirect. Revisit on any intake/auth change.

**Backend lane:** framework fix is a 11→12 MAJOR (no 11.x backport); blast radius LOW for this app
(vanilla controllers/Eloquent/mailable), likely friction = telescope/collision/phpunit constraints.
mailer/mime exposure verified LOW (recipients/From/Subject hardcoded, no Reply-To).

**Remediation sequence (build step — pending PM ruling):**
- GROUP A — composer transitive point bumps (20/22 composer alerts, NO composer.json edit). Safe, first.
- GROUP B — npm safe bumps (34/35 npm alerts; axios floor edit optional). Safe, second.
- GROUP C — needs-a-decision majors: C1 `vite` 5→6 (clears `esbuild` #12; `laravel-vite-plugin`
  already supports v6); C2 Laravel 11→12 (clears #85/#86 — the only fix path).
- Verify gate each group: `npm run build`, `./vendor/bin/pint --test`, sqlite `php artisan test`.

**Process gap (QA/devops):** CI runs `npm install` + `npm run build` only — NO `php artisan test`,
no Pint. Groups A & C2 are ungated by CI. Recommend adding a PHP test job before merging composer work.
