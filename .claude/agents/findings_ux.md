# UX / CRO Audit — GP Transmission (current state)

Audit round only — no code edited. Scope: mobile-first conversion path, hero, service-card
density, form friction, sticky-button overlap, tap targets, spacing.

Files reviewed: resources/views/main.blade.php, resources/views/contact.blade.php,
resources/views/layouts/app.blade.php, resources/views/layouts/navbars/nav_top.blade.php,
resources/views/layouts/footers/footer.blade.php, resources/scss/pages/main.scss.

## Verified resolved
- tel: linking present in nav (x2), footer, sticky bar, and contact card.
- Sticky mobile "Call Now" button exists (app.blade.php:43, styled main.scss:373), 48px min-height, d-md-none.
- Mobile nav shows logo + hamburger; service cards render on mobile with decorative images hidden (main.scss:409-428).
- Hero CTA reframed to "Request Service"; form has preferred_date / preferred_time.

---

## HIGH

### H1 — Hero is full-screen 100vh on mobile, pushing everything below the fold
main.scss:23 sets #Header { height: 100vh } with NO mobile override, and the h1 uses
font-size: 7.5vh (main.scss:50). On a phone the entire first screen is one headline + one
button, and the header_bg decorative image still loads fetchpriority="high"
(main.blade.php:54). This is the exact "too much vertical space on phones" complaint — the hero
itself is the worst offender now that cards are fixed.
- Fix: add a mobile rule in main.scss near line 49, e.g.
  @media (max-width: 767.98px) { #MainPage #Header { height: auto; min-height: 70vh; padding: 3rem 0; } #MainPage #Header .header_content-description { font-size: 2rem; } }
  Reduce the gap from the CTA (mt-5 at main.blade.php:62) to mt-4.

### H2 — No phone number / call CTA visible in the hero on mobile
The hero only offers "Request Service" (main.blade.php:64-68). On mobile the call number is
buried in the collapsed hamburger and only the floating bubble surfaces it. For a "worried driver"
the fastest conversion is tap-to-call. Add a secondary tel: button beside/under Request Service.
- Fix: in main.blade.php after the Request Service form (line 68), add
  <a href="tel:+15067907776" class="btn btn-lg ...">Call 506-790-7776</a>.

### H3 — Sticky "Call Now" bubble overlaps the form submit button & footer
.mobile-call-bar is position: fixed; bottom: 1rem; right: 1rem (main.scss:373-388) with no
bottom padding reserved on body. On the contact page the bubble sits directly over the
"Send My Request" button (contact.blade.php:148) and over the footer's tap-to-call link
(footer.blade.php), causing mis-taps on the two most important actions.
- Fix: @media (max-width: 767.98px) { body { padding-bottom: 4.5rem; } } in main.scss, or a
  bottom spacer on the form's submit column.

---

## MED

### M1 — #main-item-7 is a wall of text cards on mobile ("too many words")
main.blade.php:124-130 renders 4 stacked <h2> lines (+ SUSPENSION / + AIR CONDITIONER /
+ BATTERIES / + MORE), each a full-width card row on mobile. Combined with 6 other stacked cards
this is a long scroll of near-identical tiles.
- Fix: render the "+ more" list as a single compact line (Suspension · A/C · Batteries · and more)
  instead of 4 heading lines. Edit main.blade.php:124-130.

### M2 — Service cards have no action; they're decorative, not conversion paths
Each .main-item-md (main.blade.php:76-131) is a static tile. On mobile especially every block
should move toward call/form.
- Fix: wrap each card in <a href="/contact">, or add one shared CTA row after main.blade.php:132:
  "See a service you need? Request it →".

### M3 — Contact form: 13 fields shown at once, several optional ones add friction
contact.blade.php exposes VIN, License Plate, Kilometres, Asset Number all on first view
(lines 86-116). "Asset Number" is fleet jargon most retail customers won't understand and it spans
full width (col-12, line 110) giving it false prominence.
- Fix: move VIN/Plate/KM/Asset into a collapsed <details>Vehicle details (optional)</details>
  block, or at minimum demote Asset Number out of col-12 and add helper text.

### M4 — Submit button is low-contrast and small relative to its importance
contact.blade.php:148 uses btn btn-light (light grey on the dark form background) — the primary
conversion action visually recedes.
- Fix: give the submit a high-contrast accent (the blue #2f64ae used on the sticky bar) and
  w-100 on mobile. Adjust contact.blade.php:148 class + a .btn rule in SCSS.

### M5 — #ContactPage mobile top margin is a magic 100px
main.scss:9-13 hard-codes margin-top:100px on mobile to clear the fixed nav — fragile and can
leave a big empty band above the form on phones (more wasted vertical space).
- Fix: tie the offset to actual nav height or reduce; verify no visible empty gap above
  "Customer Information Form" on a real phone.

---

## LOW

### L1 — Nav item count
Navbar2 (sticky) adds "Home" (nav_top.blade.php:93) making 5 items; logo already links home.
Consider dropping "Home".

### L2 — Typos / polish in nav
nav_top.blade.php:11 "Sign In" vs line 19 "Login In" (should be "Log In"); line 77 "Sigin" typo;
lowercase "complaints" labels (lines 46, 106). Cosmetic.

### L3 — Reviews/WhyUs copy hidden on mobile
main.blade.php:146-164 and 177 wrap descriptive <p> in d-none d-md-block — right for word-count,
but strips supporting trust copy on mobile. Acceptable trade-off; flag only if owner wants it.

### L4 — Hero header_bg preloaded high-priority but low value on mobile
main.blade.php:54 fetchpriority="high" on a decorative overlay image — costs LCP on mobile.
Cross-cutting — perf lane.

### L5 — Empty alt text on hero + card images
main.blade.php:54,79,86,95,103,110,120 use alt="". Hero brand image should carry alt.
Cross-cutting — a11y/SEO lane.

---

## Cross-cutting flags
- L4 hero image priority -> perf/a11y.
- M4 button color + sticky bubble color reuse -> confirm with brand (accent blue).
- L5 alt text, L1 nav anchors -> SEO/a11y.
