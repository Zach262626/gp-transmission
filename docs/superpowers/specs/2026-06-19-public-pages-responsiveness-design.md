# Public Pages Responsiveness — Design

**Date:** 2026-06-19
**Status:** Approved (design)
**Scope:** Home (`main.blade.php`) and Service Request / contact (`contact.blade.php`) — the public-facing pages.
**Approach:** A — Targeted fixes (low risk; no restructure, no image/font pipeline).

## Goal

Make the public pages work well on mobile **and** feel faster to load. Two concerns, addressed together:

- **Layout:** the services showcase is currently hidden on phones, and the cards depend on a hover interaction that doesn't exist on touch.
- **Speed:** the whole page is blank until every asset loads, jQuery is downloaded twice, and dead Owl Carousel assets load on every page.

## Problems being fixed (current state)

1. `#Main` (the TIRES / TRANSMISSIONS / MVI / OIL CHANGES / BRAKES / TUNE UPS grid) is wrapped in `class="d-none d-md-block"` → invisible on mobile. Phone visitors jump from the header straight to the map/contact section.
2. Service cards (`.main-item-md`) reveal their image via a `:hover` transform (description slides up). Touchscreens have no hover, so the images never show on mobile.
3. Cards use only `col-md-*` column classes (no base `col-`) and a fixed `height: 250px`.
4. A duplicate plain-text services list exists in `#Contact` (`d-block d-md-none`) purely because the real grid was hidden on mobile.
5. `layouts/app.blade.php` sets `html { visibility: hidden }` and only reveals the page on `window.load` (after all images/scripts) → blank screen as perceived load time.
6. jQuery is loaded twice from CDN: full copy in `<head>`, min copy before `</body>`; neither deferred.
7. Owl Carousel CSS (`owl.carousel.min.css`, `owl.theme.default.min.css`) and JS (`owl.carousel.min.js`) load on every page, plus an init block in `main.blade.php`, but the carousel markup is commented out — pure dead weight.
8. Header and card images are PNGs with no `width`/`height` (layout shift) and no lazy-loading.

## Changes

### 1. Mobile services section — layout (`main.blade.php`, `pages/main.scss`)

- Remove `d-none d-md-block` from `#Main` so the grid renders on all viewports.
- Add base column classes alongside the existing `col-md-*`:
  - Tires / Transmissions row → `col-12 col-md-5` and `col-12 col-md-7`
  - MVI / Oil Changes / Brakes row → `col-6 col-md-4` (2-up on mobile, stays 3-up on desktop)
  - Tune Ups / "+ Suspension…" row → `col-12 col-md-7` and `col-12 col-md-5`
- In `pages/main.scss`, add a `@media (max-width: 767px)` rule inside `#Main` so on mobile:
  - `.main-item-md` height becomes `auto` (content-sized) instead of fixed `250px`.
  - The hover transform on `.main-item-description` is neutralized; the card image displays **statically** (visible by default), since hover is unavailable on touch.
- Remove the redundant `d-block d-md-none` services text list from `#Contact` in `main.blade.php` — the real grid now covers mobile.

### 2. Perceived speed (`layouts/app.blade.php`, `main.blade.php`)

- **Remove the full-page visibility gate:** delete the inline `html { visibility: hidden; background: #000c21; }` style block. Reveal/hide the loader on `DOMContentLoaded` rather than `window.load` so first paint is not blocked on images.
- **jQuery once, deferred:** keep a single jQuery `<script>` with `defer`; remove the duplicate copy before `</body>`. The remaining page scripts are `type="module"` (already deferred), so jQuery (classic `defer`) is guaranteed to execute first.
- **Remove dead Owl Carousel assets:**
  - Delete the two owl `<link rel="stylesheet">` tags and the `<script src="js/owl.carousel.min.js">` in `app.blade.php`.
  - Delete the `.owl-carousel` init `<script>` block at the bottom of `main.blade.php`.
- **Image attributes:** add `width`/`height`, `loading="lazy"`, and `decoding="async"` to the below-the-fold service card images in `main.blade.php`. The header background image keeps eager loading (it is the LCP element) but also gets explicit `width`/`height` to prevent layout shift.

### 3. Shared-file note

The `app.blade.php` edits (visibility gate, jQuery dedupe, owl removal) apply site-wide because the layout is shared. These are all safe removals/dedup that benefit every page; no page-specific layout depends on the removed behavior.

## Out of scope (Approach A)

- WebP / image format conversion and regeneration.
- Self-hosting the Google font / removing the SCSS `@import`.
- Restructuring the dual navbar (`#Navbar1` / `#Navbar2`) into a single responsive navbar.
- Login, signin, and complaints pages.

## Verification

There are no automated frontend tests in this project. Verify manually:

1. `npm run build` completes without errors.
2. Run the app; load the **home** page at a mobile viewport (≤576px):
   - The services grid is visible, cards stack/2-up sensibly, and each card's image shows without needing hover.
   - No blank-screen flash on load; content paints before all images finish.
   - Navbar still toggles and links work.
3. Load the home page at desktop width: services grid and hover animation unchanged from before.
4. Load the **contact** page at mobile and desktop width: form and layout intact; no console errors from removed Owl Carousel.