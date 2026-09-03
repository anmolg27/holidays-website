# Product

<!-- impeccable:product-schema 1 -->

## Platform

web

## Users

Travelers researching an Uttarakhand trip — pilgrimage (Char Dham), trekking, honeymoon, family, or weekend getaways — who want cab transportation, hotel/homestay accommodation, and a guided itinerary bundled into one arrangement, arranged through a local operator rather than a generic OTA. They arrive to browse curated Travel Packages, then reach out via WhatsApp or an inquiry form. They are not completing a purchase on this site; every visit ends in a conversation, not a transaction.

## Product Purpose

A lead-generation website for Uttarakhand Tours, a local travel operator. It showcases curated Travel Packages and converts visitors into Leads (an expressed interest, captured via WhatsApp click-to-chat or an inquiry form). There is no online payment or booking anywhere on the site (see `docs/adr/0002-lead-generation-only.md`).

## Positioning

Unlike a generic OTA/aggregator, Uttarakhand Tours bundles cab transportation, hotel/homestay accommodation, and a guided itinerary into one package, backed by a real local operator a visitor can reach directly (WhatsApp, a per-package inquiry form, or an open-ended Custom Package Request form for visitors who don't want a pre-built package). Trust and directness are the mechanism, not price comparison or self-service booking.

## Operating Context

- Content is managed entirely by a non-technical content manager through wp-admin — see `docs/client-guide.md` for the exact workflows (adding a Travel Package, managing its gallery, updating the WhatsApp number, adding a region/theme, updating Mountain Advisory content).
- Package Regions: Garhwal, Kumaon, Char Dham, Border circuits. Package Themes: Pilgrimage, Trekking, Honeymoon, Family, Weekend.
- A Mountain Advisory (road conditions, monsoon/weather updates, permit requirements, recommended gear) is manually written per package by the client — not a live feed.
- Visitors reach the site over 3G/4G mountain connections, which is a first-class performance constraint, not an afterthought (see ticket 13 in `.scratch/uttarakhand-tours-site/issues/`).

## Capabilities and Constraints

- No online payment, checkout, or availability confirmation anywhere (ADR-0002). `package_price` is a plain admin-entered "starting from" value — never computed.
- Classic (non-FSE) WordPress PHP theme, not a block theme (ADR-0001).
- System font stack only, no web fonts (ADR-0003) — a direct consequence of the 3G/4G performance constraint.
- Images are served as WebP sub-sizes with explicit lazy-loading; Contact Form 7 and other plugin assets are scoped to only the pages that need them (ticket 13). Any visual work must not regress this.
- Terminology is fixed by `CONTEXT.md` — e.g. "Travel Package" not "tour/trip/product", "Lead" not "booking/order/reservation". Visual/copy work should respect this vocabulary.

## Brand Commitments

- Confirmed name: **Uttarakhand Tours** (used consistently as the theme's `Theme Name` and `Author` in `style.css`).
- No logo file exists anywhere in the repo. Agreed direction (this session): a styled text-only wordmark for now, not a designed logo mark.
- No existing color palette or typography — this is the first visual design pass the project has had.
- Agreed tone (this session): warm & welcoming, family-run-feeling local operator — trust-building for first-time inquirers, not rugged-adventure or premium-glossy-agency.

## Evidence on Hand

- **No real photography exists yet.** The dev site's media library is empty; Travel Package galleries, the sitewide gallery, and testimonial photos are all currently unpopulated. Future work must design a tasteful placeholder/empty state for these, not fabricate stock imagery or invented testimonials.
- No customer testimonials, case studies, or press exist. The `testimonial` CPT is built and ready but has no real entries.

## Product Principles

1. Every interactive path ends in a Lead (WhatsApp or a form submission) — never a payment or booking flow.
2. Content must stay 100% editable by a non-technical client through wp-admin; nothing user-facing should require a developer to change after handoff.
3. Performance for low-bandwidth mountain connections is a hard constraint on every visual decision (fonts, images, animation), not a trade-off to revisit later.
4. Warmth and directness over glossy/corporate — the design should read as a real local operator, not an anonymous booking platform.
