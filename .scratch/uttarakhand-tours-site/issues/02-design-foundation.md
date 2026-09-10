# 02: Design foundation and site shell

**What to build:** The visual language every later page is built from — colour, typography, spacing, base components, and the header/footer shell. Establishing this before content pages exist is the point: pages built afterwards are consistent by construction rather than restyled later.

There are no existing brand assets, so visual direction is part of this work. The brief is a regional specialist a family would trust with a Char Dham trip, not a generic travel template.

Use the `impeccable` skill for this ticket — its `new-work` playbook is written for establishing a visual world where none exists. Output `DESIGN.md` at the repo root as the durable record of that direction, so later page tickets build against a written brief rather than re-deriving one.

**Blocked by:** 01

**Status:** ready-for-human

- [x] Design tokens exist for colour, type scale, and spacing, defined once and consumed everywhere
- [x] Base components exist: button, card, form field, section shell
- [x] Site shell exists: header with navigation, footer, and mobile navigation
- [x] A styleguide route renders every token and component for review
- [x] Layouts are authored mobile-first and verified at small widths with no horizontal scroll
- [x] Colour pairings meet WCAG AA contrast; focus states are visible on every interactive element
- [x] Motion respects `prefers-reduced-motion`
- [x] No heavy UI framework is introduced; CSS payload is justified against Core Web Vitals
- [x] `DESIGN.md` records the visual direction: palette, typography, spacing rhythm, and the character the site projects

## Comments

Visual world: Haridwar yatra booklet (marigold cover, newsprint interior, sindoor stamp, deodar footer). Tokens in `app/globals.css` and `lib/tokens.ts`. Shell in `components/site-header.tsx` / `site-footer.tsx`. Base components: `Button`, `Card`, `Field`, `Section`. Review at `/styleguide` (`noindex`). Contrast pairings asserted in `lib/tokens.test.ts`. Mobile nav is `details`/`summary` (no JS). Verified at 390 and 1440: no horizontal scroll.
