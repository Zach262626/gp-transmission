# Public Pages Responsiveness Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Make the public pages (home + Service Request) usable on mobile and faster to first paint, without restructuring the navbar or touching image formats.

**Architecture:** Pure Blade + SCSS changes in a Laravel 11 / Bootstrap 5 app. Show the services grid on mobile with touch-friendly static cards, and strip render-blocking / dead front-end weight from the shared layout. No new dependencies, no JS framework, no automated front-end test harness exists — verification is `npm run build` plus manual viewport checks.

**Tech Stack:** Laravel 11 Blade, Bootstrap 5 (compiled via Vite), SCSS, jQuery (CDN).

## Global Constraints

- **Branch:** Do all work on a new branch `frontend-responsiveness` — never commit directly to `main`.
- **Scope:** Public pages only — `main.blade.php` (home) and `contact.blade.php` (Service Request). The shared layout `layouts/app.blade.php` is edited too; those edits must be safe for every page (login, signin, complaints, testing).
- **No restructure:** Do NOT merge or rebuild the dual navbar (`#Navbar1`/`#Navbar2`). Do NOT convert images to WebP or change the font setup.
- **jQuery stays synchronous:** A single jQuery `<script>` in `<head>`, NOT deferred — the `/testing` page runs classic inline `$(...)` scripts and select2 that require jQuery before parse.
- **Verification per task:** `npm run build` must succeed, then load the affected page(s) in a browser at a mobile width (≈375px) via devtools device mode. There are no Jest/PHPUnit tests for the front end.

---

## File Structure

- `resources/views/layouts/app.blade.php` — shared layout. Remove the full-page visibility gate, dead Loader/reveal scripts, dead Owl Carousel CSS+JS, and the duplicate jQuery copy.
- `resources/views/main.blade.php` — home page. Show `#Main` services grid on mobile (responsive columns + remove `d-none`), remove the duplicate mobile-only services text list, remove the dead Owl init script, add lazy-loading to below-the-fold images.
- `resources/scss/pages/main.scss` — add a mobile media query so service cards size to content and show their image statically (no hover dependency).
- `resources/views/contact.blade.php` — **no direct edits**; it inherits the shared-layout speed fixes. Included only in verification.

---

## Task 1: Lean out the shared layout (speed + dead-asset removal)

Removes the blank-screen-until-loaded gate, the duplicate jQuery, the dead Owl Carousel assets, and the scripts that reference a non-existent `#Loader` element (currently a silent console error on every page).

**Files:**
- Modify: `resources/views/layouts/app.blade.php`
- Modify: `resources/views/main.blade.php` (remove dead Owl init block only)

**Interfaces:**
- Consumes: nothing.
- Produces: a shared layout that paints immediately, loads jQuery once (synchronously), and no longer requests `css/owl.carousel.min.css`, `css/owl.theme.default.min.css`, or `js/owl.carousel.min.js`.

- [ ] **Step 1: Create the working branch**

```bash
git checkout -b frontend-responsiveness
```

- [ ] **Step 2: Replace the `<head>` in `app.blade.php`**

Replace this exact block (lines ~4–29):

```html
<head>
    <style>
        html {
            visibility: hidden;
            background: #000c21;
        }
    </style>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{-- Owl Carousel Styles --}}
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">
    <meta name="description" content="Experts in transmission repair and auto services in Campbellton. Call 506-790-7776 or submit a service request form.">


    <link rel="shortcut icon" href="./favicon.ico">
    {{-- Jquery --}}
    <script src="https://code.jquery.com/jquery-3.7.1.js"
        integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <title>GP Transmission</title>

    @vite(['resources/scss/app.scss', 'resources/js/app.js'])

    <!-- Loader CSS only uses dark background -->
    @yield('header')
</head>
```

with:

```html
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Experts in transmission repair and auto services in Campbellton. Call 506-790-7776 or submit a service request form.">

    <link rel="shortcut icon" href="./favicon.ico">
    {{-- jQuery: single synchronous copy. The /testing page's classic inline scripts and select2 need it before parse, so do NOT add defer. --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <title>GP Transmission</title>

    @vite(['resources/scss/app.scss', 'resources/js/app.js'])

    @yield('header')
</head>
```

- [ ] **Step 3: Replace the `<body>` end scripts in `app.blade.php`**

Replace this exact block (lines ~31–54):

```html
<body id="{{ $activePage }}">
    @include('layouts.navbars.nav_top', ['headerId' => $headerId ?? 'Header', 'type' => $type ?? 'main'])

    @yield('content')
    @include('layouts.footers.footer')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous">
        </script>
    @yield('js')
    {{-- owl carousel --}}
    <script type="module" src="js/owl.carousel.min.js"></script>
    <script>
        window.addEventListener('load', () => {
            document.documentElement.style.visibility = 'visible';
            document.documentElement.style.background = 'none';
            document.getElementById('Loader').style.display = 'none';
        });
    </script>
    <script type="module">
        jQuery(window).on("load", function () {
            $('#Loader').hide();
        });
    </script>
</body>
```

with:

```html
<body id="{{ $activePage }}">
    @include('layouts.navbars.nav_top', ['headerId' => $headerId ?? 'Header', 'type' => $type ?? 'main'])

    @yield('content')
    @include('layouts.footers.footer')
    @yield('js')
</body>
```

- [ ] **Step 4: Remove the dead Owl init script from `main.blade.php`**

Replace this exact block at the end of the `@section('content')` (lines ~230–246):

```html
    <script type="module">
        $(document).ready(function () {
            (function ($) {
                $('.owl-carousel').owlCarousel({
                    padding: 5,
                    center: true,
                    items: 5,
                    loop: true,
                    //autoplay:true,
                    autoplayTimeout: 2000,
                    autoplayHoverPause: true,
                    animateOut: 'fadeOut'
                })
            })(jQuery);
        });
    </script>
@endsection
```

with:

```html
@endsection
```

- [ ] **Step 5: Build and verify**

Run: `npm run build`
Expected: build completes with no errors.

Then serve the app (`php artisan serve`, or your WAMP/Apache URL) and load the **home page**. In browser devtools:
- **Console:** no `Cannot read properties of null (reading 'style')` error (the old `#Loader` error is gone).
- **Network:** no requests for `owl.carousel.min.css`, `owl.theme.default.min.css`, or `owl.carousel.min.js`; exactly **one** `jquery-3.7.1.min.js` request.
- **Visual:** page content paints right away (no dark blank screen before images finish).
- Also load `/contact` and confirm the form renders and there are no console errors.

- [ ] **Step 6: Commit**

```bash
git add resources/views/layouts/app.blade.php resources/views/main.blade.php
git commit -m "perf: strip blank-screen gate, dead owl carousel assets, and duplicate jQuery from shared layout"
```

---

## Task 2: Show the services grid responsively on mobile

Unhides `#Main` on phones, makes its Bootstrap columns responsive, and removes the now-redundant mobile-only services text list in the home page's contact section.

**Files:**
- Modify: `resources/views/main.blade.php`

**Interfaces:**
- Consumes: the lean layout from Task 1 (no functional dependency, but build on that branch).
- Produces: `#Main` rendered at all viewport widths with `col-12`/`col-6` base classes; the `d-block d-md-none` services `<div>` in `#Contact` removed.

- [ ] **Step 1: Remove `d-none d-md-block` from `#Main`**

Replace (line ~26):

```html
    <div id="Main" class="d-none d-md-block">
```

with:

```html
    <div id="Main">
```

- [ ] **Step 2: Make the first card row responsive (Tires / Transmissions)**

Replace (lines ~29 and ~36):

```html
                <div class="col-md-5 p-2">
```
```html
                <div class="col-md-7 p-2">
```

with, respectively:

```html
                <div class="col-12 col-md-5 p-2">
```
```html
                <div class="col-12 col-md-7 p-2">
```

- [ ] **Step 3: Make the middle card row responsive (MVI / Oil Changes / Brakes)**

This row has three `<div class="col-md-4 p-2">` (lines ~45, ~52, ~60). Change all three to:

```html
                <div class="col-6 col-md-4 p-2">
```

(`col-6` = two cards per row on mobile, `col-md-4` = three per row on desktop, unchanged.)

- [ ] **Step 4: Make the last card row responsive (Tune Ups / + Suspension…)**

Replace (lines ~69 and ~77):

```html
                <div class="col-md-7 p-2">
```
```html
                <div class="col-md-5 p-2">
```

with, respectively:

```html
                <div class="col-12 col-md-7 p-2">
```
```html
                <div class="col-12 col-md-5 p-2">
```

- [ ] **Step 5: Remove the redundant mobile-only services text list**

Delete this entire block from the `#Contact` section (lines ~145–163):

```html
                <div class="col-md-6 contact-item-md d-block d-md-none">
                    <div class="business shadow-lg container h-100">
                        <div class="fs-2 text-center border-bottom">
                            <strong>Services</strong>
                        </div>
                        <ul class="">
                            <li>Transmissions</li>
                            <li>Tires</li>
                            <li>MVI</li>
                            <li>Oil Changes</li>
                            <li>Brakes</li>
                            <li>Tune ups</li>
                            <li>Suspensions</li>
                            <li>Air Conditioner</li>
                            <li>Batteries</li>
                            <li>And More</li>
                        </ul>
                    </div>
                </div>
```

(Leave the `reach-us` and `business`-hours columns that follow it intact.)

- [ ] **Step 6: Build and verify**

Run: `npm run build`
Expected: build completes with no errors.

Load the **home page** in devtools device mode at **375px**:
- The services grid (TIRES, TRANSMISSIONS, MVI, OIL CHANGES, BRAKES, TUNE UPS, "+ SUSPENSION…") is now visible.
- Big cards span full width; the three middle cards sit two-per-row.
- The contact section shows only "HOW TO REACH US" and "Business Hours" (no duplicate "Services" list).

At **desktop width (≥768px)**: the grid layout is unchanged from before (5/7, 4/4/4, 7/5).

- [ ] **Step 7: Commit**

```bash
git add resources/views/main.blade.php
git commit -m "feat: show services grid on mobile with responsive columns; drop duplicate services list"
```

---

## Task 3: Make service cards touch-friendly on mobile

The cards reveal their image via a `:hover` transform that never fires on touch. Add a mobile media query so cards size to content and show their image statically.

**Files:**
- Modify: `resources/scss/pages/main.scss`

**Interfaces:**
- Consumes: the now-visible `#Main` grid from Task 2.
- Produces: mobile styling for `.main-item-md` and `.main-item-description` under `#Main`.

- [ ] **Step 1: Add the mobile media query inside `#Main`**

In `resources/scss/pages/main.scss`, find this block (the end of the `#Main { ... }` rule, lines ~161–168):

```scss
        .main-item-description {
            img {
                height: auto;
                width: 100%;
            }

        }
    }
```

Replace it with (adds the media query before `#Main`'s closing brace):

```scss
        .main-item-description {
            img {
                height: auto;
                width: 100%;
            }

        }

        // No hover on touch devices: let cards size to their content and keep
        // the image in place instead of relying on the hover slide-up reveal.
        @media (max-width: 767px) {
            .main-item-md {
                height: auto;
                min-height: 160px;
            }

            .main-item-md .main-item-description,
            .main-item-md:hover .main-item-description {
                transform: none;
            }
        }
    }
```

- [ ] **Step 2: Build and verify**

Run: `npm run build`
Expected: build completes with no errors (SCSS compiles).

Load the **home page** at **375px**:
- Each service card is tall enough to show its title AND its image (cards grow to fit; no clipped/empty cards).
- No reliance on tapping/hovering to see the image.

At **desktop width**: hover still slides the image up as before (the override only applies under 768px).

- [ ] **Step 3: Commit**

```bash
git add resources/scss/pages/main.scss
git commit -m "style: make service cards size to content and show images statically on mobile"
```

---

## Task 4: Lazy-load below-the-fold images

Add `loading="lazy"` + `decoding="async"` to the service-card images (below the fold) so mobile doesn't download them until needed. The header image stays eager (it's the LCP) but gets async decoding.

**Files:**
- Modify: `resources/views/main.blade.php`

**Interfaces:**
- Consumes: the visible grid from Task 2.
- Produces: image tags with explicit loading hints. No layout/`width`/`height` attributes are added — these images are CSS-sized (`object-fit: cover` / `width: 100%`), so HTML dimensions would not reduce layout shift and could distort them.

- [ ] **Step 1: Add async decoding to the header image**

Replace (line ~5):

```html
        <img class="header_bg" src="./img/cards/gptransmission.png" alt="car-wallpaper.jpg">
```

with:

```html
        <img class="header_bg" src="./img/cards/gptransmission.png" alt="GP Transmission shop" decoding="async">
```

- [ ] **Step 2: Lazy-load the six service-card images**

Each card image currently looks like `<img class="header_bg" src="./img/cards/NAME.png" alt="tire.png">`. Update all six (srcs: `tire.png`, `car.png`, `key.png`, `oil.png`, `pedals.png`, `car2.png`) to add `loading="lazy" decoding="async"`. For example, replace:

```html
                        <div class="main-item-description"><img class="header_bg" src="./img/cards/tire.png" alt="tire.png">
```

with:

```html
                        <div class="main-item-description"><img class="header_bg" src="./img/cards/tire.png" alt="Tire service" loading="lazy" decoding="async">
```

Apply the same change to the other five (`car.png` → alt "Transmission service", `key.png` → "Motor vehicle inspection", `oil.png` → "Oil change", `pedals.png` → "Brake service", `car2.png` → "Tune ups"), each gaining `loading="lazy" decoding="async"`.

- [ ] **Step 3: Build and verify**

Run: `npm run build`
Expected: build completes with no errors.

Load the **home page** at **375px** with devtools Network tab open:
- The card images (`tire.png`, `car.png`, etc.) are **not** requested on initial load; they request as you scroll down to them.
- The header image still loads immediately.
- All images still display correctly (no distortion).

- [ ] **Step 4: Commit**

```bash
git add resources/views/main.blade.php
git commit -m "perf: lazy-load below-the-fold service images and async-decode header"
```

---

## Final verification (whole feature)

- [ ] `npm run build` succeeds.
- [ ] Home page at 375px: services grid visible, cards show images without hover, no blank-screen flash, two-per-row middle cards, no duplicate services list, navbar toggles, no console errors.
- [ ] Home page at ≥768px: visually identical to before except faster paint (hover animation intact).
- [ ] `/contact` at 375px and desktop: form intact, no console errors, no Owl Carousel network requests.
- [ ] Quick sanity load of `/login`, `/signin`, `/testing` to confirm the shared-layout edits didn't break jQuery-dependent pages (especially `/testing`'s select2 dropdowns).

---

## Self-Review

**Spec coverage:**
- Mobile services visible (spec change 1) → Task 2 Step 1.
- Responsive column classes (spec change 1) → Task 2 Steps 2–4.
- Static image on touch / auto height (spec change 1) → Task 3.
- Remove duplicate services text list (spec change 1) → Task 2 Step 5.
- Remove visibility gate / paint on DOM ready (spec change 2) → Task 1 Steps 2–3 (gate removed entirely; with no `#Loader` element, no reveal script is needed).
- jQuery once (spec change 2) → Task 1 Steps 2–3. **Deviation:** kept synchronous instead of `defer` because `/testing` runs classic inline jQuery + select2; rationale recorded in Global Constraints and Task 1.
- Remove dead Owl Carousel assets (spec change 2) → Task 1 Steps 2–4.
- Image lazy-load + decoding (spec change 2) → Task 4. **Deviation:** omitted `width`/`height` attributes because these images are CSS-sized (`object-fit`/`width:100%`); HTML dimensions wouldn't cut layout shift and risk distortion. Recorded in Task 4 Interfaces.

**Placeholder scan:** No TBD/TODO; every code step shows exact before/after content.

**Type/selector consistency:** Selectors referenced (`#Main`, `.main-item-md`, `.main-item-description`, `#Contact`) match the existing markup and SCSS. The kept jQuery integrity hash (`sha256-/JqT3S…`) matches the `.min.js` file reused from the original bottom-of-body script.
