# GP Transmission expert panel

A four-person review team for the GP Transmission website. Each member is a Claude Code
subagent defined in this folder and invokable by name via the Agent/Task tool.

| Agent | File | Lens |
|-------|------|------|
| `seo-expert` | `seo-expert.md` | Local & technical SEO |
| `ux-cro-expert` | `ux-cro-expert.md` | UX & conversion |
| `frontend-perf-a11y-expert` | `frontend-perf-a11y-expert.md` | Performance & accessibility |
| `brand-content-expert` | `brand-content-expert.md` | Brand, copy, content, bilingual |

## How they work together
1. **Audit** — each member reviews the current state through its lens and writes findings
   to `PANEL_NOTES.md` (one section per member).
2. **Cross-talk** — members read each other's notes and resolve conflicts (e.g. rich
   imagery vs. performance; new pages vs. nav simplicity). Decisions are recorded in
   `PANEL_NOTES.md`.
3. **Fix** — members apply changes in their lane. To avoid edit collisions, only one member
   edits a given file at a time; coordinate ownership in the notes.
4. **Verify** — `npm run build`, `./vendor/bin/pint --test`, and
   `DB_CONNECTION=sqlite DB_DATABASE=:memory: php artisan test` must all pass before handoff.

## Ground rules
- Mobile-first; watch vertical space and word count on phones.
- Never fabricate business facts (reviews, warranty terms, history) — leave `TODO (owner)`.
- No jQuery / Owl Carousel; Bootstrap 5 native only.
- Keep server-rendered content crawlable; defer third-party scripts.
