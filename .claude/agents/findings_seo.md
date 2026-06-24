# SEO Audit — Findings (audit round, no code edited)

Canonical NAP: "GP Transmission & Auto Repair Inc.", 47 Rue Vanier, Campbellton, NB, E3N 1T8, +1-506-790-7776.
JSON-LD on home (AutoRepair) and services (FAQPage) both parse as VALID JSON.

## HIGH
- H2 contact.blade.php:1-2 — Contact page (primary conversion page) has NO @section('title') or @section('meta_description'); falls back to generic layout default and duplicates the home title. It IS in the sitemap so it gets indexed with a generic dup title. Add title + meta.
- H3 routes/web.php:17 — /testing route is publicly reachable (returns 200), only soft-blocked by robots Disallow (advisory). Remove or gate behind auth/local.
- H1 layouts/app.blade.php:11,19 — canonical/og:url use url()->current(), which inherits whatever scheme/host the request arrives on (http vs https, www vs apex). Confirm APP_URL is the https canonical host so url() emits the single canonical origin.

## MED
- M1 layouts/app.blade.php:20 — og:image is img/cards/gptransmission.png = 2604x1398, ~2.8MB. Ship a dedicated 1200x630 compressed share card; add og:image:width/height/alt.
- M2 layouts/app.blade.php:8,10,16,18 — og:title/og:description FALLBACK strings differ from the <title>/<meta description> fallbacks. Make them identical.
- M3 main.blade.php:45-47 — JSON-LD sameAs lists only Facebook; add the Google Business Profile link (already used at main.blade.php:180, g.co/kgs/itpTF2k) to tie structured data to the GBP.
- M4 routes/web.php:37-47 — sitemap has no <lastmod>; add for freshness. Keep robots in sync with routes.

## LOW
- L1 NAP verified CLEAN — name/address/phone consistent across main.blade.php:215, about.blade.php:17/44, JSON-LD, og:site_name; phone consistent. Prior typo fix confirmed applied.
- L2 app.blade.php:2 — lang=en only; bilingual EN/FR region. No FR variant yet so no hreflang needed now; add hreflang fr-CA/en-CA when FR ships (TODO).
- L3 Heading order verified CLEAN — main/services/about each have exactly one <h1>, sections are <h2> (visual size via .h4/.h5 utilities, semantic level intact). No skipped levels.
- L4 app.blade.php:29, nav_top.blade.php:5/64/67, main.blade.php:54+ — relative ./img and ./favicon.ico paths can mis-resolve on non-root routes; use asset().
