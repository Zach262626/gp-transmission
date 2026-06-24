# GP Transmission expert panel

The review & build team for the GP Transmission website. Each member is a Claude Code
subagent defined in this folder and invokable by name via the Agent/Task tool. The **human
owner is the Project Manager (PM)**; Claude (main session) acts as **facilitator** and the
`tech-lead-architect` coordinates the specialists.

## Engineering
| Agent | File | Lens |
|-------|------|------|
| `tech-lead-architect` | `tech-lead-architect.md` | Architecture, scoping, trade-offs, coordination |
| `laravel-backend-expert` | `laravel-backend-expert.md` | Laravel 11 backend, intake flow, mail, routing, auth |
| `database-expert` | `database-expert.md` | MySQL schema, migrations, indexes, queries |
| `devops-ci-expert` | `devops-ci-expert.md` | GitHub Actions, Vite build, env/config, deploy |
| `security-expert` | `security-expert.md` | Validation, auth, honeypot/throttle, PII, deps |
| `qa-testing-expert` | `qa-testing-expert.md` | PHPUnit Feature/Unit/Integration coverage |

## Front-end & marketing
| Agent | File | Lens |
|-------|------|------|
| `frontend-expert` | `frontend-expert.md` | Blade/Bootstrap/SCSS/JS implementation craft |
| `seo-expert` | `seo-expert.md` | Local & technical SEO |
| `ux-cro-expert` | `ux-cro-expert.md` | UX & conversion |
| `frontend-perf-a11y-expert` | `frontend-perf-a11y-expert.md` | Performance & accessibility |
| `brand-content-expert` | `brand-content-expert.md` | Brand, copy, content, bilingual |

## How the team "talks" (PM-facilitated panel)
Subagents do not message each other directly; the facilitator relays. A topic runs in rounds:

1. **PM frames** the topic/goal (the human sets direction and constraints).
2. **Positions** — the facilitator dispatches each relevant expert; each returns its position,
   risks, and what it needs from others, written to `PANEL_NOTES.md` (one section per member).
3. **Cross-talk** — each expert reads the others' notes and reacts: agreements, conflicts
   (e.g. imagery vs. performance, new auth vs. simplicity, a schema change's blast radius),
   and proposed resolutions. The `tech-lead-architect` summarizes the debate and the options.
4. **PM decides** — the facilitator presents options + a recommendation; the **PM rules**.
   The ruling is recorded in `DECISIONS.md`.
5. **Build** — owners apply changes in their lane (one owner per file at a time; coordinate in
   `PANEL_NOTES.md`).
6. **Verify** — `npm run build`, `./vendor/bin/pint --test`, and
   `DB_CONNECTION=sqlite DB_DATABASE=:memory: php artisan test` must all pass before handoff.

## Ground rules
- **Confidentiality:** never write secrets, `.env` values, API keys, credentials, tokens, or
  customer PII into `PANEL_NOTES.md`, `findings_*.md`, `DECISIONS.md`, or any committed file.
  Reference config by name/path only (e.g. `ADMIN_EMAIL`), never its value.
- The PM owns product behavior, the auth model, and data-retention decisions — experts
  recommend, the PM decides; disagreements go to the PM, not forced consensus.
- Mobile-first; watch vertical space and word count on phones.
- Never fabricate business facts (reviews, warranty terms, history) — leave `TODO (owner)`.
- No jQuery / Owl Carousel; Bootstrap 5 native only. Keep server-rendered content crawlable.
- Prefer `config()` over `env()`; persist only the validated subset; keep diffs minimal.
