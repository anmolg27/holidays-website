# AGENTS.md

## Agent skills

### Issue tracker

Issues and specs live as markdown files under `.scratch/`. See `docs/agents/issue-tracker.md`.

### Triage labels

Default canonical labels (`needs-triage`, `needs-info`, `ready-for-agent`, `ready-for-human`, `wontfix`). See `docs/agents/triage-labels.md`.

### Domain docs

Single-context: root `CONTEXT.md` + `docs/adr/`. See `docs/agents/domain.md`.

### Frontend and design work

Any ticket that renders UI invokes the `impeccable` skill. That includes page layout, components, forms, empty and error states, responsive behaviour, accessibility, motion, and design tokens — not just the two dedicated design tickets.

`DESIGN.md` at the repo root is the visual source of truth, the way `CONTEXT.md` is for domain language. Read it before UI work; it is created by ticket 02. Do not re-derive visual direction per page.

Do not stack a second design skill on top. One opinion about direction.
