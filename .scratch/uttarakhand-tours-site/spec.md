# Uttarakhand Tours Website

Status: ready-for-agent

## Problem Statement

An Uttarakhand-focused travel and tour company (cab transportation + hotel/homestay accommodation + guided itineraries across Garhwal, Kumaon, and Char Dham) has no website. Prospective travelers researching Uttarakhand trips have no way to discover the company's curated Travel Packages, compare options, or get in touch — inquiries currently depend entirely on offline channels. The company also has no low-cost way to publish new packages or update trip-specific safety information (road conditions, monsoon advisories) without developer involvement.

## Solution

A custom WordPress website (classic PHP theme, zero paid plugins) built around a `travel_package` custom post type. Visitors browse and filter Travel Packages by region and travel theme, view full package details (route, pricing, accommodation, inclusions/exclusions, gallery, advisory), and convert into Leads via a persistent WhatsApp click-to-chat button, a per-package inquiry form, or an open-ended Custom Package Request form. The client manages all content themselves post-launch (packages, taxonomy terms, advisories, testimonials) through the standard WordPress admin and ACF fields, guided by documentation delivered alongside the theme. See [CONTEXT.md](../../CONTEXT.md) for the full glossary, and [ADR-0001](../../docs/adr/0001-classic-php-theme.md) / [ADR-0002](../../docs/adr/0002-lead-generation-only.md) for the architecture decisions this spec builds on.

## User Stories

1. As a traveler researching Uttarakhand trips, I want to see a homepage with a hero search/filter bar, featured packages, popular regions, trust badges, and testimonials, so that I can quickly judge whether this company fits my trip.
2. As a traveler, I want to filter the package archive by region (Garhwal, Kumaon, Char Dham, Border circuits), travel theme (Pilgrimage, Trekking, Honeymoon, Family, Weekend), duration, and price, so that I can narrow down to packages relevant to me.
3. As a traveler, I want filter results to load as a normal page (not require JavaScript to see results), so that the site stays usable on slow mountain mobile networks.
4. As a traveler, I want each package card in the archive to show its featured image, title, region/theme, duration, and starting price, so that I can compare packages at a glance.
5. As a traveler, I want a single package page showing the full itinerary, inclusions/exclusions, hotel tier, meal plan, vehicle options, and starting price, so that I understand exactly what's included before contacting the company.
6. As a traveler, I want to see a photo gallery on a package's page, so that I can see what the trip actually looks like.
7. As a traveler, I want to see an interactive map on a package's page showing the approximate route and key stops, so that I understand the journey geographically.
8. As a traveler, I want to see a Mountain Advisory callout on a package's page with current road conditions, monsoon/weather notes, permit requirements, and recommended gear, so that I can prepare properly and assess safety.
9. As a traveler, I want a persistent floating WhatsApp button on every package page that pre-fills the package title in the chat message, so that I can quickly ask about a specific package with minimal effort.
10. As a traveler, I want an "Inquire About This Package" CTA on a package's page, so that I have a clear, obvious next step to take interest further.
11. As a traveler, I want a per-package inquiry form (travel date, passenger count, preferred vehicle), so that I can request more information or a custom itinerary tied to a specific package.
12. As a traveler who doesn't want a pre-built package, I want an open-ended Custom Package Request form (region, travel dates, passenger count, vehicle preference, accommodation tier, notes), so that I can request a fully custom trip without picking from the existing package list.
13. As a traveler submitting either form, I want to understand that I'm requesting a quote/callback, not completing a booking or payment, so that my expectations match how the company actually operates.
14. As a traveler, I want to see real customer testimonials and trip photos on the homepage, so that I can trust the company based on past customers' experiences.
15. As a traveler, I want to see an About Us / Fleet & Hotels Overview page describing the company, driver expertise on mountain roads, fleet options, and partnered stays, so that I can evaluate the company's credibility and offerings.
16. As a traveler, I want a Contact page with company details and both the custom inquiry form and WhatsApp click-to-chat, so that I have one clear place to reach the company regardless of which channel I prefer.
17. As a site content manager (the client), I want to create, edit, and publish new Travel Packages through the standard WordPress admin (title, featured image, gallery, taxonomies, all ACF fields, itinerary/inclusions/exclusions), so that I can add or update offerings without a developer.
18. As a content manager, I want to add new Package Region or Package Theme taxonomy terms myself, so that I can expand into new regions or travel styles without a developer.
19. As a content manager, I want to set and update each package's starting price myself as a plain field, so that pricing changes don't require code changes.
20. As a content manager, I want to enter a package's approximate route stops (place name + coordinates) as a simple field, so that the route map renders without me needing any mapping expertise.
21. As a content manager, I want to write and update the Mountain Advisory text for a package myself (road conditions, monsoon updates, gear advice), so that safety information stays current without a developer, since it is not pulled from any live external feed.
22. As a content manager, I want to add customer testimonials and their photos myself, so that social proof stays current without a developer.
23. As a content manager, I want documentation explaining how to add new packages, manage galleries, and update the WhatsApp contact number, so that I can operate the site independently after handover.
24. As the business owner, I want the WhatsApp number used across the site (floating button and per-package CTA) to be a single, easily updatable value, so that changing the contact number doesn't require touching multiple templates.
25. As the business owner, I want zero paid plugins used anywhere in the build, so that the site has no recurring license costs.
26. As a mobile visitor on a 3G/4G mountain connection, I want fast page loads with optimized images (WebP, lazy loading) and minimal JavaScript, so that the site is usable even with poor connectivity.
27. As the business owner, I want the site to never process payments or confirm bookings itself, so that all trip logistics and payment collection stay in the company's existing manual workflow (phone/WhatsApp/in-person).

## Implementation Decisions

- **Theme architecture**: Classic PHP theme (not a block/FSE theme) per ADR-0001. Required templates: `functions.php`, `front-page.php`, `archive-travel_package.php`, `single-travel_package.php`, plus standard `page.php`/`header.php`/`footer.php` for About, Fleet/Hotels, and Contact pages. Block editor used for in-content editing only.
- **Custom Post Type**: `travel_package`, registered via `register_post_type()` in code (no CPT UI plugin).
- **Taxonomies**: `package_region` (Garhwal, Kumaon, Char Dham, Border circuits) and `package_theme` (Pilgrimage, Trekking, Honeymoon, Family, Weekend), both registered in code, both left open for the client to add new terms via the standard WordPress admin taxonomy UI (not restricted to a fixed list).
- **Custom fields**: ACF (free tier only) fields on `travel_package` per the domain schema: `package_price` (single flat starting-from value, admin-entered, no computed pricing anywhere), `package_duration`, `pickup_drop_location`, `vehicle_options`, `driver_allowance_included`, `toll_parking_included`, `hotel_tier`, `meal_plan`, `itinerary_content`, `inclusions`, `exclusions`, Mountain Advisory text field(s), and Route Stops (a repeatable place-name + coordinate pair field, kept as plain data with no assumption baked in about a future live-routing source).
- **Gallery**: Native WordPress gallery (core `gallery` block or native attachment handling) per package — no ACF Pro-style repeater. The sitewide/homepage photo gallery is an aggregation of these existing per-package galleries; no separate gallery-upload mechanism.
- **Route map**: Leaflet + OpenStreetMap (no API key, no billing account, genuinely free). Renders the package's Route Stops as markers connected by straight waypoint lines — not a road-following route from a Directions API. No elevation/altitude chart; altitude is descriptive text within itinerary/advisory content only.
- **Archive filtering**: Server-side, via query string parameters mapped to `WP_Query`/taxonomy queries (region, theme, duration, price) — no AJAX/JS-driven filtering, to keep JS minimal and pages fast on low-bandwidth connections.
- **Lead capture**: Contact Form 7 (free) powers both the per-package inquiry form and the standalone Custom Package Request form. Custom Package Request fields: region (from `package_region` terms), travel dates (start date + duration), passenger count, vehicle preference, accommodation tier, notes. Neither form computes or displays a price; submissions are pure inquiries.
- **WhatsApp integration**: A single WhatsApp number stored as one site-wide value (e.g. a theme option/customizer setting), consumed by (a) a persistent floating click-to-chat button present on every package page, and (b) a per-package "Inquire About This Package" CTA that pre-fills the package title into the WhatsApp deep-link message. Documented how to update this number.
- **Mountain Advisory**: Manually written/updated content field(s) on `travel_package`, covering road conditions, monsoon/weather updates, permit requirements, and recommended gear. No live external feed (confirmed: USDMA/PWD sources expose no API or RSS — see conversation record). Field shape kept simple enough to swap for a live source later without a schema rewrite, but no such integration is built now.
- **Testimonials**: Manually entered content (a CPT or ACF repeater), including reviewer name and photo, editable like any other content — not pulled from an external reviews API.
- **Pricing/booking boundary**: Per ADR-0002, no payment gateway, no availability calendar, no booking confirmation flow anywhere in the site.
- **Currency**: INR only, `₹` prefix on all displayed prices, no currency selection logic.
- **Performance**: Responsive CSS without a heavy UI framework; image optimization (WebP delivery, lazy loading) for featured images and galleries; minimal JavaScript overall (Leaflet for maps is the primary JS dependency beyond core WordPress/theme JS).
- **Visual design**: No existing brand assets. Visual design (palette, typography, layout polish) is handled separately via the `impeccable` skill, not decided as part of this spec — this spec covers structure, data, and behavior only.
- **Deliverables**: Theme folder with clean, commented PHP templates; ACF field configuration exported (acf-json or PHP export) for field sync across environments; clean CSS/SCSS and minimal JS; documentation covering adding packages, managing galleries, and updating the WhatsApp number.

## Testing Decisions

- **Primary seam**: WordPress integration tests (PHPUnit against the WordPress test suite, e.g. via `wp-env`), seeding fixture `travel_package` posts, taxonomy terms, and ACF field values, then asserting against rendered template output — not against internal function calls or mocked WordPress APIs.
- What "rendered output" tests should cover: archive filtering (correct posts returned/excluded for a given region/theme/duration/price query), single-package field display (price, duration, gallery images present, route stops rendered as map data, advisory text present), the WhatsApp CTA's generated `href` (correct number and pre-filled package title), and the presence/fields of both lead-capture forms.
- Good tests assert on externally observable behavior (rendered HTML, query results, generated URLs) rather than internal implementation details (specific function names, private helper structure) — implementation can be refactored freely as long as rendered behavior holds.
- **Secondary seam**: plain PHP unit tests (no WordPress bootstrap) for genuinely pure helper functions with no WordPress dependency — e.g. a WhatsApp deep-link URL builder, price formatting. Use this only where such isolated pure functions exist; don't force logic out of WordPress-integrated code just to unit-test it.
- No prior art in this codebase (greenfield project) — these seams are being established for the first time here, not following an existing test pattern.

## Out of Scope

- Online payment processing or booking/availability confirmation of any kind (ADR-0002).
- Any live data integration for the Mountain Advisory (no USDMA/weather API — confirmed no public API/feed exists; deferred by explicit choice).
- Road-following driving routes or elevation/altitude charts (Directions API, elevation API) — route maps use approximate waypoints only, altitude is descriptive text.
- A separate/standalone photo gallery upload system — the sitewide gallery only aggregates existing per-package galleries.
- A shared/reusable "Route" entity across packages — route data is per-package only for now.
- Multi-currency support.
- Any paid plugin, theme, or service (Elementor Pro, ACF Pro, premium form plugins, etc.).
- Hosting/deployment decisions — explicitly deferred; this spec covers the local build only.
- Final visual design (colors, typography, layout polish) — handled separately via the `impeccable` skill.
- Live weather API integration.

## Further Notes

- This is a greenfield repo — no existing WordPress installation, theme code, or content exists yet. All templates, CPT/taxonomy registrations, and ACF field groups are net-new.
- Domain vocabulary for this feature lives in [CONTEXT.md](../../CONTEXT.md) (Travel Package, Lead, Package Region, Package Theme, Mountain Advisory, Custom Package Request, Route Stops) — implementation and future specs should use these terms rather than synonyms.
- Two ADRs underpin this spec: [0001-classic-php-theme.md](../../docs/adr/0001-classic-php-theme.md) and [0002-lead-generation-only.md](../../docs/adr/0002-lead-generation-only.md).
