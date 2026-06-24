# Decision log — GP Transmission

PM rulings from panel discussions. Newest first. One entry per decision so context survives
across sessions. Keep each entry short: what was decided, why, and what it affects.

Template:
```
## YYYY-MM-DD — <short title>
- **Decision:** <what the PM ruled>
- **Context:** <the question / options that were on the table>
- **Why:** <the deciding rationale>
- **Owners / follow-up:** <who does what next, or "none">
```

---

## 2026-06-24 — Dependabot remediation: PM rulings
- **Decision:** (1) Run the safe bumps now — **Group A** (composer transitive point bumps, ~20
  alerts) and **Group B** (npm safe bumps, ~34 alerts). (2) **vite 5→6 now** with a build
  smoke-check (clears `esbuild` #12 → npm to zero). (3) **DEFER Laravel 11→12** (#85/#86) and
  track here as accepted risk. (4) **Add a PHP-test CI gate** (composer install + sqlite
  `php artisan test` + Pint) before merging composer changes.
- **Context:** 57 Dependabot alerts. Panel positions (security/devops/backend) reached
  consensus: none internet-exploitable today; 54/57 clear with safe one-shot bumps; 3 need majors.
- **Why:** Clear the noise cheaply now and gate composer work with real tests. The framework
  major is the *only* fix for #85/#86 but the affected `email` rule has **no reachable header
  sink** in this app (validated emails go to DB + escaped body only), so it's a planned change,
  not a vuln emergency.
- **Owners / follow-up (EXECUTION OUTCOME):** Done on `dev`.
  - **npm: all 35 alerts cleared** (Groups B + C1 — axios floor ^1.16.0, form-data 4.0.6,
    rollup/picomatch/immutable/postcss, vite 5→6 pulling esbuild ≥0.25). `npm audit` = 0. Build green.
  - **composer: partial.** During Group A the Symfony 7.4 security patches (http-foundation,
    mime, mailer, routing, yaml) and psy/psysh were found to transitively pull **symfony/console
    7.4, which breaks Laravel 11.44.7 command dispatch** (`artisan` crashes: "Call to a member
    function make() on null"). So only the console-independent advisories were applied
    (guzzle 7.12.3, psr7 2.12.3, commonmark 2.8.2, phpunit 11.5.55, polyfill-intl-idn 1.38.1).
  - **NEW coupling:** the remaining Symfony advisories cannot be patched on the 11.x line and are
    now **bundled into the deferred Laravel 11→12 upgrade**. All 69 tests green after the bumps.
  - **CI:** added a PHP-test job (composer install + sqlite `php artisan test`); build bumped to
    node 20 for vite 6. Pint gate intentionally NOT added yet (14 pre-existing style issues — needs
    a separate `pint` cleanup pass first).
  - Revisit Laravel 11→12 + remaining Symfony advisories on a maintenance window, or sooner per
    the reachability watch-items above.

## 2026-06-24 — Add a dedicated front-end implementation engineer
- **Decision:** Add `frontend-expert` (Blade/Bootstrap 5/SCSS/JS implementation craft),
  distinct from `frontend-perf-a11y-expert` (optimization & accessibility audit) and
  `ux-cro-expert` (conversion). Brings the team to 11 members.
- **Context:** PM asked for a front-end expert; the panel had perf/a11y and UX lenses but no
  one owning the actual markup/styles/interactivity build quality.
- **Why:** "Is it fast/accessible" and "does it convert" are separate from "is the Blade/SCSS/JS
  well-built and maintainable." That implementation lane needed an owner.
- **Owners / follow-up:** `frontend-expert` builds UI; hands perf to perf/a11y and conversion to UX.

## 2026-06-24 — Stand up the full engineering + marketing panel
- **Decision:** Expand the panel from the 4 marketing agents to a 10-member team by adding
  `tech-lead-architect`, `laravel-backend-expert`, `database-expert`, `devops-ci-expert`,
  `security-expert`, and `qa-testing-expert`. Discussions run as a PM-facilitated panel with
  cross-talk rounds; the human owner is the PM and makes the calls.
- **Context:** PM wanted a team of stack experts that "talk as a team" while the PM directs.
- **Why:** The existing panel only covered SEO/UX/perf/brand; shipping changes to a Laravel +
  MySQL + CI stack needs backend, DB, devops, security, and QA lenses plus a coordinator.
- **Owners / follow-up:** Facilitator runs the round protocol in `PANEL.md`; rulings logged here.
