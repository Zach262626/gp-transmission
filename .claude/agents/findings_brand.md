# Brand & Content Audit — GP Transmission (current state)

Audit only; no code edited. References are file:line against the current tree.
Lens: brand/copy/content, mobile word-count, tone consistency, placeholder leakage,
fabricated business facts.

## HIGH

### H1. Form name placeholder is "John Doe"
contact.blade.php:39 — Full Name field still seeds placeholder="John Doe" (clichéd; same
fake-name pattern we just removed). Change to placeholder="First and last name".

### H2. Legal business name cased inconsistently ("Auto repair" vs "Auto Repair")
footer.blade.php:7 says "Auto repair Inc." (lowercase r); everywhere else uses "Auto
Repair Inc." (main:11,215; about:16,44; app:15). Fix footer to match. NOTE: Google
listing label in the map iframe (main:191) is "Auto repair Inc." too — TODO(owner):
confirm the official registered casing, then make ALL surfaces identical. Don't guess.

### H3. About page still ships TODO-placeholder boilerplate as the live story
about.blade.php:12-19, 26-32 — page body is generic copy guarded by two TODO(owner)
comments (years in business, owner background, team photo, warranty). Reads unfinished.
Correct not to fabricate, but either hold About from nav until owner supplies real copy,
or tighten so it reads intentional. Launch-gating decision.

## MED

### M1. Hero has no value-prop/reassurance line
main.blade.php:56-60 — H1 + button only. Add ONE short trust line under H1 (e.g.
"Transmission specialists serving Campbellton & the Restigouche region."), d-none
d-sm-block if phone vertical space is the worry.

### M2. Services intro lead paragraph too wordy on mobile
services.blade.php:44-48 — tighten to one sentence or wrap second sentence in d-none
d-md-block. Matches owner's "too wordy on mobile" complaint.

### M3. About intro + "Our Commitment" wordy and duplicative on mobile
about.blade.php:15-24, 30-32 — "Our Commitment" repeats lead/WhyUs points. Shorten;
d-none d-md-block on secondary paragraph.

### M4. Tone drift: ALL-CAPS service tiles vs sentence-case brand voice
main.blade.php:78,85,94,101-102,109,118-129 — shouty caps vs calm sentence-case used in
new Services/About/WhyUs. Use Title Case in markup, all-caps via CSS text-transform if
wanted (better for tone + screen readers). Coordinate with UX/perf.

### M5. "Description of Issue" placeholder is thin
contact.blade.php:140 — replace "Describe the issue in detail..." with a prompting
example ("e.g. slipping when shifting, leaking fluid, warning light, noise — and when it
started.") to convert better and reduce back-and-forth.

## LOW

### L1. Footer Hotmail not TODO-flagged (contact card is)
footer.blade.php:18,21 vs main:206-209 — keep the address per house rules but add the
matching TODO(owner) comment in the footer so the two stay in sync.

### L2. Footer copyright year hardcoded "2025"
footer.blade.php:7 — already a year stale on a 2026 site. Use {{ date('Y') }}.

### L3. Mixed CTA terminology + dead commented appointment block
main:66 / services:79 / about:35 "Request Service" vs contact:148 "Send My Request" vs
commented "MAKE AN APPOINTMENT" main:259-267. Confirm CTA verb with UX; delete the dead
commented block.

### L4. Warranty TODO still open (highest-value copy)
main:136-138, about:26-28 — correctly left as TODO(owner), not fabricated. Push owner to
supply real warranty terms; biggest trust signal for transmission work.

## Fabricated-fact check (clean)
No invented history/owner/certs/testimonials. Reviews link to real Google profile
(main:174-183). Phone/address/hours consistent across main/about/schema/footer; only
name casing (H2) differs. Bilingual EN/FR still entirely English — future phase
(indexable /fr + hreflang + lang="fr-CA"), out of scope this round.
