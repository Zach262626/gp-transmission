# Performance & Accessibility findings (round 2 audit)

## HIGH
- Hero LCP image was a 2.83 MB PNG, no WebP, no dimensions (`main.blade.php` hero).
- Hidden mobile card images (`display:none`) were still downloaded (~1.76 MB on phones).
- `./img/...` and `./favicon.ico` relative paths break on `/services`, `/about`, `/contact`
  (logo + images 404 off the homepage).
- Hero forced `height:100vh` on mobile (`main.scss`) — the "too much vertical space" symptom.

## MEDIUM
- Sticky `#Navbar2` is `visibility:hidden` + revealed by JS only (no-JS = no sticky nav).
- Non-hero `<img>` lacked width/height → CLS.
- Decorative footer SVG icons lacked `aria-hidden`.
- Google Fonts stylesheet render-blocking (preconnect + display=swap already present).

## LOW
- Nav text typos ("Login In", "Sigin", lowercase "complaints").
- Duplicate Navbar1/Navbar2 DOM; dead commented SCSS/markup.
- Heavy unused assets in public/img (GPTransmission_Logo.jpg 1.75 MB, Transmission_22.png).
- Map facade 📍 should be `aria-hidden`.
