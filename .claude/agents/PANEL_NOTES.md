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
