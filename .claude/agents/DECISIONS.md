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
