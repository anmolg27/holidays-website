# Product

<!-- impeccable:product-schema 1 -->

## Platform

web

## Users

Primary: a traveler (often a family) researching an Uttarakhand trip on a phone, frequently on a slow 3G/4G mountain connection. They need to judge whether this company can be trusted with a multi-day journey — especially Char Dham — then inquire, not book.

Secondary: the client (one non-technical owner) who publishes Travel Packages and contact details from a Google Sheet they already know how to use, from a phone as often as a laptop.

## Product Purpose

A lead-generation website for an Uttarakhand-focused tour company. It showcases curated Travel Packages (cab + hotel/homestay + guided itinerary across Garhwal, Kumaon, and Char Dham) and converts visitors into Leads via inquiry forms and WhatsApp. There is no online payment, availability check, or booking confirmation.

Success: a family is willing to hand over a phone number; the owner publishes without learning a CMS or paying a monthly host.

## Positioning

A regional specialist for Uttarakhand — not a pan-India reseller. Content is the owner's own packages and standing Mountain Advisory, not scraped inventory. Conversion is inquiry, never checkout.

## Operating Context

- Content source is one Google Sheet, published by a menu item that rebuilds the site.
- Primary visitor device is a phone; design is mobile-first.
- WhatsApp is a primary conversation and sharing channel.
- Currency is INR only (`₹` prefix).
- [Inferred from spec] Working name in the skeleton is "Uttarakhand Tours"; legal/trading name is not separately confirmed.

## Capabilities and Constraints

- No heavy UI framework. Token-layer CSS. Every kilobyte competes with Core Web Vitals and slow mountain networks.
- No existing brand assets, logo, or palette.
- WCAG AA contrast, visible focus, semantic HTML, `prefers-reduced-motion`.
- Domain language is in `CONTEXT.md`: Travel Package, Lead, Package Region, Package Theme, Mountain Advisory, Regional Alert, Custom Package Request, Route Stops. Do not substitute tour/trip/booking/alert-for-advisory.
- Hindi-language content is out of scope for v1.
- Forms request a quote or callback; none compute or display a price.

## Brand Commitments

- Character: a regional specialist a family would trust with a Char Dham trip, not a generic travel template.
- No invented testimonials, prices, or live route-open claims.

## Evidence on Hand

- Product spec: `.scratch/uttarakhand-tours-site/spec.md`
- Domain glossary: `CONTEXT.md`
- No photography, logo, or real package content yet. Seed packages in later tickets are invented and unpublished. Do not fabricate commercial claims.

## Product Principles

1. Trust before flourish — families are deciding who to travel the mountains with.
2. Specific to Uttarakhand, never generic travel.
3. Phone-first and fast; polish must not cost the page.
4. Inquiry, not booking — copy and UI must not imply a completed reservation.
5. Accessibility is part of the design, not a later audit.

## Accessibility & Inclusion

WCAG AA contrast, visible focus on every interactive element, semantic structure, touch targets sized for thumbs, motion respects `prefers-reduced-motion`. Alt text will come from the sheet in later tickets.
