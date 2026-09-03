---
name: Uttarakhand Tours
description: A warm, hand-strung "prayer-flag trail" design system for a local Uttarakhand travel operator's lead-generation site.
colors:
  flag-blue: "#3e6e8e"
  flag-red: "#b8483c"
  flag-green: "#5c7a46"
  flag-yellow: "#d9a441"
  flag-white: "#ffffff"
  ground: "#fbf6ec"
  ground-deep: "#f1e8d8"
  surface: "#fffdf8"
  ink: "#2b2420"
  ink-secondary: "#6b5f52"
  border: "#e4d9c5"
typography:
  display:
    fontFamily: "Lora, Georgia, \"Times New Roman\", serif"
    fontSize: "clamp(2rem, 5vw, 3.25rem)"
    fontWeight: 600
    lineHeight: 1.15
    letterSpacing: "-0.01em"
  body:
    fontFamily: "system-ui, -apple-system, \"Segoe UI\", Roboto, sans-serif"
    fontSize: "1rem"
    fontWeight: 400
    lineHeight: 1.6
rounded:
  sm: "8px"
  md: "14px"
  pill: "999px"
spacing:
  sm: "0.5em"
  md: "1em"
  lg: "1.5em"
  xl: "2.5em"
components:
  button-primary:
    backgroundColor: "{colors.flag-red}"
    textColor: "{colors.flag-white}"
    rounded: "{rounded.pill}"
    padding: "0.7em 1.75em"
  button-primary-hover:
    backgroundColor: "#9c3d33"
  cta-whatsapp:
    backgroundColor: "{colors.flag-green}"
    textColor: "{colors.flag-white}"
    rounded: "{rounded.pill}"
    padding: "0.7em 1.5em"
  card:
    backgroundColor: "{colors.surface}"
    textColor: "{colors.ink}"
    rounded: "{rounded.md}"
    padding: "1.25em"
  tag-region:
    backgroundColor: "#d9e6ee"
    textColor: "{colors.flag-blue}"
    rounded: "{rounded.pill}"
    padding: "0.2em 0.75em"
  tag-theme:
    backgroundColor: "#f5e3c3"
    textColor: "#8a6420"
    rounded: "{rounded.pill}"
    padding: "0.2em 0.75em"
---

# Design System: Uttarakhand Tours

## Overview

**Creative North Star: "Prayer-Flag Trail"**

Every touchpoint reads as a string of prayer flags along a mountain route: a repeating band of small color-blocked triangles marks passage and progress across the site, standing in for the generic OTA card-grid-on-white that every travel-booking template defaults to. The palette is drawn directly from the five traditional Himalayan flag colors — sky, cloud, fire, water, earth — and each one is given a real, working UI role (region tags, theme tags, primary actions, WhatsApp CTAs) rather than sitting as pure decoration. The system is warm and hand-strung, not glossy or corporate: a family-run local operator's site, not an anonymous booking platform.

This direction was assigned by a randomized concept-seed process (seed key `e649fc9d`) against a self-authored list of Uttarakhand-grounded visual candidates, then raised by fusing three unrelated catalog challengers against it — a donated ink-stamp/permit motif (the Mountain Advisory callout), a rhythm-as-signal discipline (the flag-band's density varies deliberately, never as filler texture), and a procession-pacing idea (Route Stops/Itinerary read as a journey, not a flat list). See `.impeccable/surfaces/wp-content-themes-uttarakhand-tours-front-page-php.md` for the full direction contract.

No real package photography exists yet (the client has not uploaded any). Every image-bearing slot has a tasteful placeholder — the same flag-band motif, muted and scaled to its container — rather than a blank box or a generic gray fill.

**Key Characteristics:**
- One signature graphic device (the flag-band) repeated everywhere, never diluted into generic decoration
- Full-palette color strategy: five named roles, each doing real UI work
- One self-hosted display serif (Lora) for headings; system font stack for everything else, in service of the site's 3G/4G performance constraint
- Warm hemp-paper ground, never stark white
- No gradients, no glass, no drop shadows without real offset+blur

## Colors

Warm and earthy — a hemp-paper ground with five saturated-but-muted flag colors, each reserved for a specific job rather than scattered as decoration.

### Primary
- **Fire Red** (#b8483c): primary buttons, form submits, the Mountain Advisory ink-stamp seal, focus rings, link-hover color.

### Secondary
- **Water Green** (#5c7a46): the WhatsApp family of CTAs (floating button, inquire buttons) — a distinct action color from the red primary, so "talk to us" reads differently from "submit a form".

### Tertiary
- **Sky Blue** (#3e6e8e): default link color, Package Region tags, secondary interactive elements.
- **Earth Yellow** (#d9a441): Package Theme tags, the flag-band's warm accent note.

### Neutral
- **Hemp Ground** (#fbf6ec): the page background — warm, never stark white.
- **Deep Hemp** (#f1e8d8): placeholder fills, divider tone.
- **Card Surface** (#fffdf8): card and form-field backgrounds, barely warmer than white so cards read as a distinct plane above the ground.
- **Ink** (#2b2420): body text, headings — a warm near-black, never pure `#000`.
- **Ink Secondary** (#6b5f52): captions, durations, secondary copy — tinted from ink, never gray.
- **Border** (#e4d9c5): form-field borders.

### Named Rules
**The Full-Palette Rule.** All five flag colors are always in play across a page — never reduced to a single accent-on-neutral scheme. Each color is pinned to one job (red = primary action, green = WhatsApp, blue = region, yellow = theme) so the palette reads as a system, not a rainbow.

## Typography

**Display Font:** Lora (self-hosted, semibold/600 only), with Georgia and "Times New Roman" fallbacks
**Body Font:** system-ui, -apple-system, "Segoe UI", Roboto, sans-serif

**Character:** A warm, book-ish serif for headings against a clean, invisible system sans for reading — the pairing should feel like a well-printed local brochure, not a tech product.

### Hierarchy
- **Display / H1** (600, `clamp(2rem, 5vw, 3.25rem)`, 1.15 line-height): page titles, the homepage hero headline.
- **Headline / H2** (600, `clamp(1.35rem, 3vw, 1.85rem)`, 1.15 line-height): section headings.
- **Body** (400, 1rem, 1.6 line-height, capped at 68ch on long-form content): itinerary, inclusions/exclusions, page copy.
- **Label** (500, 0.8-0.9rem): tags, durations, form labels — system font, never the display face.

### Named Rules
**The One Weight Rule.** Only Lora 600 is loaded — no italic, no additional weights. Hierarchy comes from size and color, not from adding more font files.

## Layout

Mobile-first, two breakpoints (640px, 1024px), no framework. Card grids (`package-cards`, `testimonials-list`, `sitewide-gallery`, `popular-regions`, `trust-badges`) run 1 column on mobile, 2 at 640px, 3-4 at 1024px, capped at a 75em (1200px) container. Detail pages (single package, About, Contact) intentionally use a *narrower* 52em container — a wide, mostly-empty detail page reads as unfinished, not spacious — with long-form text further capped at 68ch inside that. Section rhythm runs on em-based steps: 0.5em (tight groups), 1-1.5em (related elements, grid gaps), 2.5em (between major sections).

## Elevation & Depth

Hybrid: flat page background, lifted cards. Every card declares elevation exactly once (a soft shadow, never a border-plus-shadow "ghost card" stack).

### Shadow Vocabulary
- **Soft** (`0 4px 16px rgba(43, 36, 32, 0.1)`): resting state for cards, buttons, badges.
- **Lift** (`0 8px 28px rgba(43, 36, 32, 0.16)`): package-card hover state, paired with a `translateY(-2px)`.

### Named Rules
**The One Shadow Rule.** A card is either flat or has exactly one soft shadow — never both a border and a shadow standing in for depth.

## Shapes

Cards and images use a 14px radius (`--radius`); pills (buttons, tags) use a full 999px radius (`--radius-pill`); form fields use a tighter 8px. No hard-offset "neobrutalist" shadows — every corner is soft, matching the hand-strung, unglossy character of the system.

## Components

### Buttons
- **Shape:** full pill (999px radius)
- **Primary** (submit buttons, "Search Packages"): fire red background, white text, `0.7em 1.75em` padding.
- **WhatsApp family** (floating button, inquire CTAs): water green background, white text — visually distinct from form-submit actions.
- **Hover:** background darkens ~15% (`color-mix`), no shadow change.

### Tags (Region / Theme)
- **Region:** pale sky-blue background tint, blue text, pill shape.
- **Theme:** pale earth-yellow background tint, deep gold text, pill shape.
- Both sit in a `flex-wrap` row beneath a package card's title, never stacked as a list.

### Cards
- **Corner Style:** 14px radius.
- **Background:** Card Surface (#fffdf8).
- **Shadow Strategy:** Soft at rest, Lift + 2px translateY on hover.
- **Border:** none — elevation comes from shadow alone.
- **Internal Padding:** 1.25em.

### Image Placeholders
- **Style:** the same flag-bunting motif used in the signature band, muted (35% opacity colors) and tiled at a scale proportionate to the container — a small, dense tile for card thumbnails; one large, calm, centered *row* (not a filled tile) for hero-scale featured images, so it reads as "a string of flags in an empty space" rather than wallpaper.
- **When shown:** any package, testimonial, or gallery slot with no uploaded photo yet.

### Inputs / Fields
- **Style:** 1px Border (#e4d9c5), Card Surface background, 8px radius.
- **Focus:** 2px fire-red outline, 2px offset (via `:focus-visible`, themed — never the browser default blue).

### Navigation
- Wordmark (Lora, 1.35rem) + a plain-text horizontal link list, both stacked full-width on mobile (no hamburger — the link list wraps naturally at 4 items), inline side-by-side from 640px up. Hover shifts link color to fire red.

### The Flag-Band (signature component)
A repeating inline-SVG bunting pattern (5 triangular pennants — blue, white, red, green, yellow — hung from a thin rope line) used as: (1) a persistent strip directly under the site header on every page, (2) a calmer, larger-tiled variant in the footer, and (3) the muted placeholder fill for missing images. It is the one graphic device the whole system is built around — every other visual choice supports it rather than competing with it.

## Do's and Don'ts

### Do:
- **Do** keep all five flag colors doing real work on every page — don't let the palette collapse to "just red" out of convenience.
- **Do** use the flag-band motif for any new placeholder or empty state — it's the system's answer to "nothing here yet", not a generic gray box.
- **Do** cap long-form body text at 68ch, even inside a wider container.
- **Do** give detail/content pages (anything that isn't a card grid) the narrower 52em container — resist stretching them to the full 75em grid width.

### Don't:
- **Don't** add a second display typeface or additional Lora weights — one face, one weight, hierarchy from size alone.
- **Don't** use a colored `border-left`/`border-right` on cards, callouts, or alerts — the Mountain Advisory's ink-stamp seal is the system's answer to "how do we mark something as important", not a colored border.
- **Don't** load a web font from a third-party CDN — Lora is self-hosted specifically to avoid that request (see `docs/adr/0003-system-fonts-only.md`).
- **Don't** stack a border and a shadow on the same card for elevation — pick one.
