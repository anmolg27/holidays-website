---
name: Uttarakhand Tours
description: A yatra-booklet visual system for an Uttarakhand specialist families can trust with a Char Dham trip.
colors:
  ink: "#1B1F24"
  ink-muted: "#3A423C"
  paper: "#E4E6E1"
  paper-deep: "#D5D7D1"
  cover: "#E8B52A"
  cover-deep: "#C49212"
  alta: "#9C1C16"
  alta-deep: "#7A1410"
  pine: "#1A4336"
  pine-bright: "#245C49"
  white: "#FFFFFF"
  rule: "#8A8F88"
typography:
  display:
    fontFamily: "Rasa, Georgia, serif"
    fontSize: "clamp(2.5rem, 8vw, 4.5rem)"
    fontWeight: 600
    lineHeight: 1.15
    letterSpacing: "-0.02em"
  headline:
    fontFamily: "Rasa, Georgia, serif"
    fontSize: "1.5rem"
    fontWeight: 600
    lineHeight: 1.15
    letterSpacing: "-0.02em"
  title:
    fontFamily: "Rasa, Georgia, serif"
    fontSize: "clamp(1.75rem, 4vw, 2.5rem)"
    fontWeight: 600
    lineHeight: 1.15
    letterSpacing: "-0.02em"
  body:
    fontFamily: "Atkinson Hyperlegible, ui-sans-serif, sans-serif"
    fontSize: "1.0625rem"
    fontWeight: 400
    lineHeight: 1.55
    letterSpacing: "normal"
  label:
    fontFamily: "Atkinson Hyperlegible, ui-sans-serif, sans-serif"
    fontSize: "0.8125rem"
    fontWeight: 700
    lineHeight: 1.55
    letterSpacing: "normal"
rounded:
  stamp: "2px"
  plate: "4px"
spacing:
  1: "0.25rem"
  2: "0.5rem"
  3: "0.75rem"
  4: "1rem"
  5: "1.5rem"
  6: "2rem"
  7: "3rem"
  8: "4rem"
  9: "6rem"
components:
  button-primary:
    backgroundColor: "{colors.alta}"
    textColor: "{colors.white}"
    rounded: "{rounded.stamp}"
    padding: "0.7rem 1.25rem"
    height: "2.75rem"
  button-primary-hover:
    backgroundColor: "{colors.alta-deep}"
    textColor: "{colors.white}"
  button-secondary:
    backgroundColor: "transparent"
    textColor: "{colors.ink}"
    rounded: "{rounded.stamp}"
    padding: "0.7rem 1.25rem"
    height: "2.75rem"
  button-ghost:
    backgroundColor: "transparent"
    textColor: "{colors.pine}"
    rounded: "{rounded.stamp}"
    padding: "0.7rem 1.25rem"
    height: "2.75rem"
  card:
    backgroundColor: "{colors.paper}"
    textColor: "{colors.ink}"
    rounded: "{rounded.plate}"
    padding: "1.5rem"
  field:
    backgroundColor: "{colors.paper-deep}"
    textColor: "{colors.ink}"
    rounded: "0px"
    padding: "0.6rem 0.75rem"
    height: "2.75rem"
---

# Design System: Uttarakhand Tours

## Overview

**Creative North Star: "The Yatra Booklet"**

The site is a cheap offset-printed Char Dham yatra booklet, not a mountain-hero travel template. The first viewport is marigold cover stock; interior pages are cool gray-green newsprint. Titles are set like a booklet cover; body type is chosen to stay readable on a phone in mountain light.

Trust is the product. A family deciding who to travel these roads with should feel a regional specialist, not a reseller. Colour is committed on the cover and restrained on interior pages. Surfaces are printed plates, not lifted cards.

**Key Characteristics:**

- Marigold cover, newsprint interior, sindoor stamp for the one action
- Rasa for titles, Atkinson Hyperlegible for body
- Bound plates with hairline rules; no drop shadows
- Mobile-first, one CSS file, no UI framework

## Colors

Printed booklet inks, not a terracotta-on-cream travel palette.

### Primary

- **Marigold cover** (#E8B52A): the header and the home cover sheet. Ink text sits on it.
- **Sindoor stamp** (#9C1C16): primary buttons and focus rings. White or newsprint labels sit on it. Used rarely.

### Secondary

- **Deodar pine** (#1A4336): footer field and link colour on newsprint.

### Neutral

- **Offset ink** (#1B1F24): body text.
- **Secondary ink** (#3A423C): hints and card meta; still AA on paper and cover.
- **Newsprint** (#E4E6E1): interior page ground.
- **Recessed plate** (#D5D7D1): form wells.
- **Rule** (#8A8F88): plate hairlines.

### Named Rules

**The Cover Rule.** Marigold is a field, not an accent chip. Header and home cover share one sheet.

**The Stamp Rule.** Sindoor is the one action. Do not scatter it as decoration.

**The Pairing Rule.** Token pairings in `lib/tokens.ts` must stay at WCAG AA. Do not introduce a pairing that fails `lib/tokens.test.ts`.

## Typography

**Display Font:** Rasa (Georgia fallback)
**Body Font:** Atkinson Hyperlegible (ui-sans-serif fallback)

**Character:** Cover lettering from an Indian Latin text face; body from a low-vision-friendly grotesque that holds up on a small, bright phone.

### Hierarchy

- **Display** (600, `clamp(2.5rem, 8vw, 4.5rem)`, 1.15, -0.02em): home cover title only.
- **Title** (600, `clamp(1.75rem, 4vw, 2.5rem)`): page titles.
- **Headline** (600, 1.5rem): section titles.
- **Body** (400, 1.0625rem, 1.55): reading copy, max ~70ch.
- **Label** (700, 0.8125rem): field labels.

### Named Rules

**The Two-Voice Rule.** Rasa is for titles and the wordmark. Atkinson is for everything a traveler has to read or tap. Do not add a third family.

## Layout

Mobile-first. Page max width `--page` (72rem), centered. Sections pad `3rem 1rem`. More space above a heading than below it (`section-title` margin-bottom 1.5rem). Cover min-height `calc(100svh - 4rem)` so the footer sits below the first fold. Breakpoints: card grid 2 columns from 40rem; desktop nav from 48rem.

Spacing scale is `--space-1` through `--space-9` (0.25rem to 6rem). Consume those tokens; do not invent one-off gaps.

## Elevation & Depth

Flat print. Depth is tonal: cover vs newsprint vs recessed plate. No shadows.

### Named Rules

**The Plate Rule.** A card is a booklet plate: newsprint, 1px rule, 4px corner. Do not lift it. Do not nest plates.

## Shapes

Stamp corners on buttons (2px). Plate corners on cards and the mobile menu (4px). Form fields are ruled wells: no radius, 2px ink underline, recessed fill. Focus is a 3px sindoor outline, offset 3px.

## Components

### Buttons

- **Shape:** 2px stamp, min-height 2.75rem, weight 700.
- **Primary:** sindoor fill, white label. Hover: alta-deep. Active: 1px press.
- **Secondary:** ink hairline, transparent fill. Hover: ink fill, newsprint label.
- **Ghost:** pine, underlined. Hover: sindoor.
- **Disabled:** 0.55 opacity, no press.

### Cards / Containers

- **Corner Style:** 4px
- **Background:** newsprint
- **Shadow Strategy:** none
- **Border:** 1px rule
- **Internal Padding:** 1.5rem
- Linked plates use the same geometry; hover darkens the rule to ink.

### Inputs / Fields

- **Style:** recessed well, 2px ink underline, no box radius.
- **Focus:** the global sindoor ring.
- **Error:** sindoor text, `role="alert"`, `aria-invalid` on the control.
- Label is always a real `<label for>`.

### Navigation

- Header is the marigold cover band. Wordmark left (Rasa). Desktop contents-list from 48rem. Below that, a `details`/`summary` Menu — no JavaScript.
- Footer is deodar pine; marigold links; the inquiry-is-not-a-booking line in newsprint-on-pine.
- Skip link is the first focusable control.

### Section shell

`.section` > `.section-inner`. Optional `<h2 class="section-title">`. This is an interior booklet page.

## Do's and Don'ts

### Do:

- **Do** start from the phone width and expand.
- **Do** consume colour, type, and space from `:root` / `lib/tokens.ts`.
- **Do** keep motion behind `prefers-reduced-motion: reduce` (transitions off).
- **Do** mark sample or unpublished content as sample — never invent live prices.
- **Do** use domain language from `CONTEXT.md` (Travel Package, Lead, inquiry — not tour, booking, reservation).

### Don't:

- **Don't** ship a mountain-hero + serif + terracotta travel template.
- **Don't** put a kicker or eyebrow above a heading.
- **Don't** introduce a UI framework or a third font family.
- **Don't** nest cards or add drop shadows.
- **Don't** copy that implies a completed booking.
