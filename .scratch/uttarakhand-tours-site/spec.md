# Uttarakhand Tours Website

Status: ready-for-agent

Supersedes the WordPress/PHP spec of the same name. See [ADR-0003](../../docs/adr/0003-google-sheets-as-cms.md) for why the stack changed; [ADR-0001](../../docs/adr/0001-classic-php-theme.md) is superseded.

## Problem Statement

An Uttarakhand-focused travel and tour company — cab transportation, hotel/homestay accommodation, and guided itineraries across Garhwal, Kumaon, and Char Dham — has no website. Prospective travelers researching Uttarakhand trips cannot discover the company's curated Travel Packages, compare options, or get in touch; inquiries depend entirely on offline channels.

The company also has no way to publish new packages or update trip-specific guidance without a developer, and no budget for recurring software costs. A conventional CMS solves the first problem by introducing a second one: an admin interface the owner must learn, hosted on infrastructure that costs money every month.

## Solution

A Next.js website deployed to Cloudflare Workers at zero recurring cost, whose entire content source is a single Google Sheet that we build, seed, and ship to the client.

Visitors browse and filter Travel Packages by Package Region and Package Theme, view full package details (itinerary, pricing, accommodation, inclusions/exclusions, gallery, route map, Mountain Advisory), see any current Regional Alert for the package's district, and convert into Leads via a persistent WhatsApp click-to-chat button, a per-package inquiry form, or an open-ended Custom Package Request form.

The client manages all content from the Google Sheet — a document they already know how to use — and publishes by clicking a menu item inside that sheet, which triggers a full site rebuild. Leads arrive as an email and as a row in a Leads tab of the same sheet.

See [CONTEXT.md](../../CONTEXT.md) for the glossary. Architecture decisions are recorded in ADRs [0002](../../docs/adr/0002-lead-generation-only.md) (lead generation only), [0003](../../docs/adr/0003-google-sheets-as-cms.md) (Sheets as CMS), [0004](../../docs/adr/0004-rebuild-not-isr.md) (rebuild not ISR), [0005](../../docs/adr/0005-cloudflare-workers-not-vercel.md) (Cloudflare not Vercel), [0006](../../docs/adr/0006-apps-script-lead-capture.md) (Apps Script lead capture), [0007](../../docs/adr/0007-regional-alert-scope.md) (Regional Alert scope) and [0008](../../docs/adr/0008-portability-seams.md) (portability seams).

## User Stories

### Traveler

1. As a traveler researching Uttarakhand trips, I want a homepage with featured packages, popular regions, trust signals, and testimonials, so that I can quickly judge whether this company fits my trip.
2. As a traveler, I want to filter the package archive by Package Region, so that I can narrow to the part of Uttarakhand I'm visiting.
3. As a traveler, I want to filter by Package Theme, so that I can find trips matching my travel style.
4. As a traveler, I want to filter by duration and starting price, so that I can narrow to trips matching my time and budget.
5. As a traveler, I want filter results to load as a normal page rather than requiring JavaScript, so that the site stays usable on slow mountain mobile networks.
6. As a traveler, I want each package card to show its featured image, title, region, theme, duration, and starting price, so that I can compare packages at a glance.
7. As a traveler, I want a single package page showing the full day-wise itinerary, so that I understand what happens on each day of the trip.
8. As a traveler, I want to see inclusions and exclusions listed explicitly, so that I know what the starting price does and does not cover.
9. As a traveler, I want to see hotel tier, meal plan, and vehicle options, so that I understand the standard of the trip before contacting anyone.
10. As a traveler, I want to see whether driver allowance and toll/parking are included, so that I can anticipate additional costs.
11. As a traveler, I want a photo gallery on a package's page, so that I can see what the trip actually looks like.
12. As a traveler, I want an interactive map showing the package's Route Stops in order, so that I understand the journey geographically.
13. As a traveler, I want to see a Mountain Advisory on a package's page covering permits, recommended gear, and what the season is typically like on that route, so that I can prepare properly.
14. As a traveler, I want to see any current Regional Alert for the package's district, with its issuing authority and expiry time, so that I am aware of official warnings affecting the area.
15. As a traveler, I want the Regional Alert to be clearly labelled as district-level context rather than route status, so that I do not mistake it for confirmation that a route is open.
16. As a traveler, I want links to official weather and disaster advisory sources relevant to this package's region, so that I can check authoritative sources myself before travelling.
17. As a traveler, I want to see when advisory and alert information was last updated, so that I can judge how current it is.
18. As a traveler, I want a persistent floating WhatsApp button on every package page that pre-fills the package title into the message, so that I can ask about a specific package with minimal effort.
19. As a traveler, I want a clear "Inquire About This Package" call to action, so that I have an obvious next step.
20. As a traveler, I want a per-package inquiry form capturing travel date, passenger count, and preferred vehicle, so that I can request details tied to a specific package.
21. As a traveler who doesn't want a pre-built package, I want an open-ended Custom Package Request form covering region, dates, passenger count, vehicle preference, accommodation tier, and notes, so that I can request a fully custom trip.
22. As a traveler submitting either form, I want to understand that I am requesting a quote or callback rather than completing a booking, so that my expectations match how the company operates.
23. As a traveler, I want confirmation that my inquiry was received, so that I know it went through and don't submit it repeatedly.
24. As a traveler, I want to see testimonials with reviewer names and photos, so that I can trust the company based on past customers.
25. As a traveler, I want an About Us and Fleet & Hotels page describing the company, driver expertise on mountain roads, fleet options, and partnered stays, so that I can evaluate credibility.
26. As a traveler, I want a Contact page with company details, the inquiry form, and WhatsApp click-to-chat, so that I have one place to reach them regardless of preferred channel.
27. As a mobile visitor on a 3G/4G mountain connection, I want fast page loads with optimized images and minimal JavaScript, so that the site is usable on poor connectivity.
28. As a traveler, I want the site to work on my phone, so that I can research trips away from a desktop.

### Content Manager (the client)

29. As a content manager, I want to receive a ready-made Google Sheet with the correct structure already in place, so that I never have to build a schema from written instructions.
30. As a content manager, I want the sheet to arrive pre-seeded with example packages, so that I can see what good content looks like rather than facing an empty grid.
31. As a content manager, I want to add a new Travel Package by duplicating an existing row and editing it, so that I don't have to remember what every column means.
32. As a content manager, I want Package Region and Package Theme to be dropdowns, so that I cannot introduce a typo that breaks filtering.
33. As a content manager, I want the sheet to refuse clearly-wrong values for price, duration, and dates, so that I catch mistakes as I type rather than after publishing.
34. As a content manager, I want a visible warning rather than a hard block on values where the rule might be imperfect, so that a slightly-unusual but valid entry isn't rejected.
35. As a content manager, I want incomplete rows highlighted automatically, so that I can see at a glance which packages aren't ready.
36. As a content manager, I want to add package photos by putting them in a shared Drive folder, so that I don't need any other tool or account.
37. As a content manager, I want to paste a Google Maps link for a Route Stop rather than typing coordinates, so that I cannot silently enter the wrong location.
38. As a content manager, I want to write a package's day-wise itinerary as separate rows, so that each day is its own entry rather than one enormous cell.
39. As a content manager, I want to keep a package unpublished while I'm still writing it, so that half-finished content never reaches visitors.
40. As a content manager, I want to publish the site by clicking a menu item inside the sheet, so that I never have to log into another system.
41. As a content manager, I want to know whether publishing succeeded, so that I'm not left guessing whether my changes are live.
42. As a content manager, when my content has errors, I want a report naming the specific row and column in plain language, so that I can fix it without help.
43. As a content manager, I want the live site to keep serving its last good version when a publish fails, so that visitors never see a broken site because of my mistake.
44. As a content manager, I want to update the WhatsApp number, phone, email, and address myself, so that contact changes don't need a developer.
45. As a content manager, I want to edit the About and Fleet & Hotels page copy myself, so that I can correct or expand it over time.
46. As a content manager, I want to manage the list of official advisory links myself, so that I can fix a link when a government site moves.
47. As a content manager, I want to add and edit testimonials myself, so that social proof stays current.
48. As a content manager, I want to write and update each package's Mountain Advisory myself, so that seasonal guidance stays accurate.
49. As a content manager, I want an email whenever someone submits a form, so that I can follow up quickly.
50. As a content manager, I want to reply to that email and reach the customer directly, so that I don't have to copy their address into a new message.
51. As a content manager, I want every Lead recorded in a tab of my sheet, so that I have a durable record even if an email is missed or deleted.
52. As a content manager, I want written documentation covering adding packages, managing photos, publishing, and interpreting error reports, so that I can operate the site independently.
53. As a content manager, I want new fields added to my sheet without losing the content I've already entered, so that upgrades are safe.

### Business Owner

54. As the business owner, I want the site to have no recurring software or hosting cost, so that it doesn't become a monthly liability while the business validates its first website.
55. As the business owner, I want the site to never process payments or confirm bookings, so that trip logistics and payment stay in the existing manual workflow.
56. As the business owner, I want one WhatsApp number used everywhere and updatable in one place, so that changing it doesn't require touching multiple pages.
57. As the business owner, I want to own the accounts the site depends on, so that the business is not dependent on a contractor's personal accounts.
58. As the business owner, I want form submissions protected from spam and abuse, so that my inbox and my daily email quota aren't exhausted by bots.

### Developer

59. As a developer, I want the sheet schema defined in one place in version control, so that adding a field doesn't require synchronised edits in three places that silently drift.
60. As a developer, I want to build and test the whole pipeline against seeded sample content, so that I'm not blocked waiting on the client's real content.
61. As a developer, I want sample content to be structurally incapable of reaching the live site, so that invented prices can never be published as real ones.
62. As a developer, I want pages and components to consume domain objects rather than spreadsheet rows, so that replacing Google Sheets with a database rewrites one module rather than the site.
63. As a developer, I want cached state reached through a small interface, so that moving off Cloudflare KV is a swap rather than a refactor.
64. As a developer, I want a scheduled build that proves the pipeline still works, so that expired credentials or broken dependencies surface before the client urgently needs to publish.
65. As a developer, I want dead outbound links reported automatically, so that link rot on government sites is caught rather than discovered by a traveler.
66. As a developer, I want the build to fail loudly and specifically when the sheet's structure has changed, so that a renamed column produces a clear error rather than silently shifted data.

### Search Visibility

67. As someone searching for "char dham tour package" or "kedarnath package from delhi", I want this company's pages to appear in results, so that I can discover them at all.
68. As a traveler scanning search results, I want the title and description to accurately describe the package, so that I click through to something matching my expectation.
69. As a traveler sharing a package link over WhatsApp, I want a rich preview showing the package photo, title, and starting price, so that the person I send it to immediately sees what I mean.
70. As a traveler searching for a region rather than a specific trip, I want a Package Region landing page with real introductory content, so that I find a relevant list rather than an unrelated single package.
71. As a traveler searching by travel style, I want a Package Theme landing page for the same reason.
72. As a traveler arriving from search on a slow connection, I want the page to render quickly enough that I don't abandon it.
73. As a search engine, I want a sitemap listing every published page with its last-modified date, so that I can discover and re-crawl content efficiently.
74. As a search engine, I want structured data describing each Travel Package, so that I can understand and richly present what is being offered.
75. As a search engine, I want filtered archive URLs to declare canonical and noindex correctly, so that I don't index hundreds of near-duplicate pages.
76. As a search engine, I want an unpublished package's URL to tell me it is permanently gone, so that I drop it promptly rather than re-crawling it for weeks.
77. As a content manager, I want to write a custom page title and meta description for a package, so that I can improve how it appears in search.
78. As a content manager, I want sensible titles and descriptions generated automatically when I leave those fields blank, so that a package is never published with an empty or duplicated title.
79. As a content manager, I want to give each photo alt text, so that images are accessible and discoverable.
80. As a content manager, I want a package's URL to stay the same when I edit its title, so that existing rankings and links people have already shared don't break.
81. As a content manager, I want the publish to fail loudly if something I changed would change a live URL, so that I find out before search engines do.
82. As the business owner, I want organic search to be a working acquisition channel, so that inquiries arrive without ad spend.
83. As the business owner, I want the company name, address, and phone number consistent everywhere on the site, so that local search treats it as one business.

### Look and Feel

84. As a traveler deciding who to trust with a multi-day trip, I want the site to look professional and credible, so that I'm willing to hand over my phone number.
85. As a traveler, I want the site to feel specific to Uttarakhand rather than a generic travel template, so that the company reads as expert in this region rather than a reseller.
86. As a traveler on a phone, I want every page to work at small widths without horizontal scrolling or tapping tiny targets, so that I can research a trip from wherever I am.
87. As a traveler scanning a package page, I want clear visual hierarchy between price, duration, itinerary, and inclusions, so that I can find what I care about without reading everything.
88. As a traveler comparing packages, I want cards to be visually consistent, so that differences between packages stand out rather than differences in layout.
89. As a traveler using a screen reader or keyboard, I want semantic structure, visible focus states, and meaningful alt text, so that the site is usable without a mouse or sight.
90. As a traveler with motion sensitivity, I want animation to respect my reduced-motion preference, so that the site doesn't make me unwell.
91. As a traveler on a slow connection, I want the design to load fast, so that visual polish never costs me the page.
92. As the business owner, I want the site to look at least as good as competing Uttarakhand tour operators, so that design isn't the reason someone picks a competitor.
93. As a developer, I want a design foundation of tokens and base components established before pages are built, so that pages are consistent by construction rather than restyled afterwards.

## Implementation Decisions

### Content pipeline

- **Source of truth** is one Google Sheet, read at build time via a **service account** with `spreadsheets.readonly`. A service account is required because API keys can only read publicly-shared files. The sheet and the Drive image folder are shared with the service account's address.
- **Content repository interface** is the only way the rest of the app reaches content. It exposes operations returning domain objects — Travel Packages, Testimonials, Settings, Useful Links — and never leaks rows, tabs, or header names. The Google Sheets implementation sits behind it (ADR-0008).
- **Schema is data, split in two.** A source-agnostic **domain schema** defines each entity's fields, types and required-ness. A **Sheets binding** maps those fields to tabs, columns, and in-sheet validation rules. The build validator, the Apps Script sheet builder, and the migration all read from these, so a new field is a one-file change.
- **Column access is by header name**, never by position, so a reordered column is harmless and a renamed one produces a clear error.
- **Tab structure** follows the hybrid decision: one row per Travel Package for flat fields; newline-separated cells for plain string lists (inclusions, exclusions); separate tabs joined by `package_slug` for multi-field ordered records (itinerary days, Route Stops, gallery images). Additional tabs cover Testimonials, Settings (key/value), Useful Links, Page Copy, and Leads.
- **Route Stops** accept a pasted Google Maps URL, from which coordinates are extracted at build time. Hand-typed coordinates are the most error-prone possible input and are not the primary path.
- **Images** live in a shared Drive folder, referenced from the sheet by filename, downloaded at build time via the Drive API using the same service account, and optimised (resize, WebP, lazy loading) during the build.
- **A `Publish` column** gates every Travel Package. The build emits only rows where it is TRUE. Seeded sample content ships as FALSE and therefore cannot reach production.

### Validation and failure

- **Two layers.** In-sheet data validation gives the client immediate feedback: hard-reject (`setAllowInvalid(false)`) on rules that cannot be wrong — region, theme, price, duration, dates — and warn-only where the rule is a guess, such as Maps URLs and image filenames. Conditional formatting highlights incomplete rows regardless.
- **Build-time validation** is the gate. Structural damage — a missing tab or column — fails the whole build. Row-level errors skip the offending row and continue.
- **The validation report** is emailed to both the client and the developer, naming row and column in plain English (`Row 7, 'Starting Price': expected a number, found '15,000/- onwards'`), never as a raw validation-library error.
- **A failed build leaves the last good deploy serving.** The client experiences "the site did not update", not "the site broke" — which is silent, making the report the sole mechanism by which they learn something is wrong.

### Publishing

- **Full rebuild only** for sheet content; no ISR or on-demand revalidation (ADR-0004).
- **The client publishes from a custom menu inside the sheet.** An Apps Script menu item POSTs to a Cloudflare deploy hook via `UrlFetchApp`. A simple `onEdit` trigger cannot do this — simple triggers cannot call services requiring authorization — so it must be a menu item or an installable trigger.
- **A weekly cron build runs as a pipeline canary**, not a content mechanism: it proves credentials, dependencies and outbound links still work on a day nobody is waiting. It also HEAD-checks every Useful Link and includes failures in the validation report, with an allowlist for government sites that block HEAD or bot user-agents.

### Lead capture

- **Path**: browser posts same-origin to a Next.js route handler, which validates, checks Cloudflare Turnstile, rate-limits, and forwards to a Google Apps Script web app bound to the sheet. The script appends the Lead to the Leads tab, then emails the owner via `MailApp` (ADR-0006).
- **Append before send**, so an exhausted email quota never loses a Lead. `MailApp.getRemainingDailyQuota()` is checked and the send skipped rather than throwing.
- **The route handler is mandatory**, not a convenience: it keeps the Apps Script URL out of the browser bundle, and Apps Script cannot see a caller's IP or origin, so it is the only place origin checks and rate limiting can exist.
- **Apps Script cannot set HTTP status codes.** `doPost` returns `{ok, error}` JSON always at 200/302; the route handler translates that into real statuses. `doPost` is wrapped in try/catch, because an uncaught error returns an HTML error page that fails JSON parsing confusingly.
- **The Apps Script call happens in `ctx.waitUntil()`** so its 1–3s latency is not on the visitor's critical path.
- **`replyTo`** is set to the lead's email address so the owner can reply directly from Gmail.
- **All three forms** — per-package inquiry, Custom Package Request, Contact — share one endpoint, discriminated by a form-type field. No form computes or displays a price.

### Regional Alert

- **Single source: the SACHET/NDMA CAP feed**, state-filtered. Keyless, declares itself public domain, and honours ETag/`If-None-Match` with a 304 (ADR-0007).
- **A cron Worker polls and persists** into the cache interface (Cloudflare KV behind it). SACHET's window is roughly 10 hours, so alerts must be accumulated rather than fetched on demand.
- **Package pages stay static**; a client-side fetch on load hits a Worker route that reads from cache and returns `{alerts, updatedAt}`. Visitors without JavaScript see no alert — accepted knowingly (ADR-0007).
- **Alert data is never written back to the content sheet.** Per-pageview sheet writes would exhaust a 60/minute quota, race under concurrency, and put a machine-writing process inside the client's validated schema.
- **District matching** uses LGD geocodes where alerts carry them, falling back to place-name matching where they carry free-text location lists instead. Alerts render with issuing authority, severity, and expiry, framed as district context.
- **The two rejected sources** — IMD's Char Dham sector portal and the Uttarakhand PWD road-closure dashboard — appear as Useful Links, not as parsed data.

### Sheet as a deliverable

- **Delivered as a `/copy` template**, not an `.xlsx` import. A native copy preserves protected ranges, notes, frozen rows and the bound Apps Script; an `.xlsx` import silently drops protection and cannot carry a script, leaving no migration path.
- **The bound Apps Script** provides the publish menu item, the schema builder, and the migration runner, all walking the declarative schema rather than containing logic.
- **Web App deployments do not copy.** The client's copy has the script but no `/exec` endpoint. Someone must deploy once in their account and hand back the URL for the Worker's environment. This is a guided handover step, walked through with the client rather than left to them.
- **Schema version is stored in `DeveloperMetadata`**, not a cell, so the client cannot delete it. Migrations are idempotent and additive: read current headers, append only what's missing, never reorder or delete. Columns are tagged with `DeveloperMetadata` at creation so a renamed header does not read as a deleted column.
- **Protection is advisory.** The sheet's owner can always edit protected ranges, so `setWarningOnly(true)` on header rows produces a real confirmation prompt, and header-name lookup in the build is the actual defence.
- **Seed content** is 5–6 invented but plausible packages spanning both taxonomies — Char Dham, Do Dham, Valley of Flowers, Auli, Nainital–Mussoorie, Jim Corbett — all at `Publish = FALSE`.

### Infrastructure

- **Cloudflare Workers via `@opennextjs/cloudflare`**, free plan (ADR-0005). Client owns the account; the developer is a member.
- **Cache interface** with `get`/`set` and TTL, implemented over Workers KV, is the only Cloudflare-specific coupling in application code (ADR-0008).
- **Google account ownership** rests with the developer initially, with a written handover trigger — the client having published successfully three times without breaking the schema. Note this means Lead notification emails send from the developer's Google account and consume its 100/day quota until handover.
- **Route map** uses Leaflet with OpenStreetMap tiles — no API key, no billing account. Route Stops render as ordered markers joined by straight waypoint lines, not a road-following route.
- **Archive filtering** is server-side via query-string parameters, producing a normal page load with no client-side filtering JavaScript.
- **Currency** is INR only, displayed with a `₹` prefix, with no conversion logic.

### Search visibility

- **Metadata is authored-with-fallback.** Each Travel Package has optional `meta_title` and `meta_description` columns. When blank, the build generates them from the package title, region, duration, and starting price. A package is never published with an empty or duplicated title, and the client is never forced to write metadata to publish.
- **Slugs are an explicit column**, authored once, independent of the title (ADR-0009). The build compares each slug against the previous deploy's manifest and **fails** on a change rather than silently publishing a new URL and orphaning the old one. Changing a slug deliberately is a supported operation, but an explicit one.
- **Indexable surface** is package pages plus single-facet archives — one Package Region or one Package Theme. Multi-facet combinations and all price/duration filters are `noindex` with a canonical to the nearest indexable parent (ADR-0009). Region and Theme each gain an intro-copy column in the sheet, because an indexable page containing only a filtered list is thin content.
- **Structured data** is JSON-LD: `TouristTrip` per Travel Package including itinerary and offer price, `TravelAgency` for the organisation with consistent name/address/phone, and `BreadcrumbList` on package and archive pages. **`AggregateRating` and `Review` are deliberately excluded** — Google discounts self-serving review markup and it carries manual-action risk for no benefit.
- **Open Graph and Twitter Card tags** on every page, with the package's featured image. This matters more here than usual: WhatsApp is a primary sharing channel for this audience, and a pasted package link should render as a card rather than a bare URL.
- **Sitemap and `robots.txt`** are generated at build time from the content repository, so they cannot drift from what was actually published. The sitemap carries `lastmod` from the sheet's last-modified time.
- **Unpublished packages return 410 Gone**, not 404, so search engines drop them promptly. A build manifest of previously-published slugs makes this possible.
- **Image alt text** is a column on the gallery tab, with a generated fallback from the package title. Images are served as WebP at responsive sizes with explicit dimensions, so layout shift stays near zero.
- **Core Web Vitals** are treated as a requirement, not an aspiration. Static generation, server-side filtering, and near-zero client JavaScript already favour this; the one runtime script (Regional Alert fetch) must be deferred and must not shift layout when it resolves.
- **Canonical URLs** are absolute and self-referencing on every indexable page, so query-string variants never fragment ranking signals.

### Visual design

- **Design is built in, not applied afterwards.** A design foundation — tokens for colour, type scale and spacing, plus base components (button, card, form field, section shell) and the site shell of header, footer and navigation — is established before content pages are built, so pages are consistent by construction. A final coherence pass follows once every page exists.
- **No existing brand assets.** Visual direction has to be established as part of the work: palette, typography, and the character the site should project. The brief is a regional specialist that a family will trust with a Char Dham trip, not a generic travel template.
- **No heavy UI framework.** Responsive CSS with a token layer. Every kilobyte of CSS and JavaScript competes with story 91 and with Core Web Vitals, which are a ranking input, not just a nicety.
- **Mobile-first.** The primary visitor is on a phone on a mountain network. Layouts are designed at small widths and expanded, never the reverse.
- **Accessibility is part of design, not a later audit.** Semantic HTML, WCAG AA contrast, visible focus states, meaningful alt text sourced from the sheet, and touch targets sized for thumbs. Motion respects `prefers-reduced-motion`.
- **Motion is deliberate and small.** Transitions serve orientation — what changed, what is loading — and nothing purely decorative that costs bytes or triggers layout shift.
- **The Regional Alert band must not shift layout when it resolves.** It is the one runtime-fetched element on an otherwise static page, so its space is reserved before the fetch returns.

## Testing Decisions

Good tests here assert on externally observable behaviour — rendered HTML, HTTP responses, generated URLs, parsed output — never on internal function names or private helper structure. Implementation should be freely refactorable as long as observable behaviour holds. There is no prior art: this is a greenfield repo and these seams are being established for the first time.

Three seams, in descending order of how much they cover.

**Seam 1 — fixture sheet payload to rendered output.** The primary seam, and the one most stories are verified through. Captured Google Sheets API responses are fed through the real content pipeline and pages are rendered; assertions are on the output. This covers archive filtering for each facet, single-package field rendering, `Publish = FALSE` exclusion, the WhatsApp deep link's generated `href` including the pre-filled package title, Route Stops reaching the map as coordinates, gallery presence, Mountain Advisory rendering, and the plain-English content of the validation report for malformed rows. Fixtures should include deliberately broken rows, since the report's wording is a user-facing behaviour worth asserting. It also covers the search-visibility surface, which is all rendered output: generated titles and descriptions when the sheet leaves them blank, `noindex` on multi-facet archive URLs and its absence on single-facet ones, self-referencing canonicals, valid `TouristTrip` and `BreadcrumbList` JSON-LD, Open Graph tags, and sitemap contents matching exactly the set of published packages. Slug-change detection is asserted by rendering against two fixture generations and expecting the build to fail.

**Seam 2 — Worker route handler, request in and response out.** One harness covers both the lead endpoint and the alerts endpoint. Apps Script, the cache, and Turnstile are stubbed at the `fetch` and binding boundary. Assertions cover: what payload is forwarded to Apps Script, what the caller receives for success and each failure, that a failed Turnstile check rejects before forwarding, that rate limiting engages, that an Apps Script `{ok:false}` body becomes a non-200 response, and that the alerts endpoint returns cached data with its `updatedAt` when the upstream source is unavailable.

**Seam 3 — pure parsers.** Plain unit tests, no harness, for the genuinely isolated transformations: SACHET CAP XML to normalised alert objects (including alerts carrying LGD geocodes and alerts carrying only free-text place lists), Google Maps URL to coordinates across the URL shapes clients actually paste, and sheet row to domain object including type coercion and required-field failures.

**Automated accessibility checks run inside Seam 1**, asserting against rendered output: heading order, form labelling, image alt text presence, and contrast on the token palette. Visual regression testing is deliberately not used — at this size it is brittle enough to cost more attention than it saves, and the design pass is verified by review.

**Deliberately not tested: the Apps Script.** It executes inside Google's runtime and cannot be meaningfully exercised from a test suite. This is a design constraint rather than a coverage gap — the script walks the declarative schema and contains no branching logic worth asserting on. Anything that grows real logic should move to the Worker or the build, where seams 2 and 3 reach it. The schema itself, being data, is testable directly.

## Out of Scope

- Online payment processing, availability checking, or booking confirmation of any kind (ADR-0002).
- Parsing IMD's Char Dham sector portal or the Uttarakhand PWD road-closure dashboard. Both are unversioned HTML that breaks silently; they appear as Useful Links only (ADR-0007).
- Any claim about whether a specific route is open or closed. No public feed carries this.
- Weather forecasts. Staged after Regional Alerts, not built now.
- Road-following driving routes and elevation charts. Route maps use approximate waypoints; altitude is descriptive text within itinerary or advisory content.
- A shared or reusable Route entity across packages. Route data is per-package.
- Server-rendered Regional Alerts. Chosen deliberately as client-side (ADR-0007).
- ISR or on-demand revalidation for sheet content (ADR-0004).
- Multi-currency support.
- A standalone photo-upload mechanism. The sitewide gallery aggregates existing per-package galleries.
- Any paid plugin, theme, hosting tier, or email vendor.
- A branded customer-facing auto-reply email. Would require Google Workspace or an email vendor; not built now (ADR-0006).
- Abstractions for the image source, form backend, alert source, or hosting target. Only the content repository and cache interfaces exist (ADR-0008).
- A preview environment for the client. Cheap to add later; deliberately omitted from v1.
- Indexing multi-facet filter combinations, or price and duration filters (ADR-0009).
- `AggregateRating` or `Review` structured data on testimonials (ADR-0009).
- Hindi-language content or `hreflang`. Potentially valuable for this market, but an entire content dimension the client would have to maintain; not v1.
- Off-site SEO: Google Business Profile setup, directory listings, backlink work. The site supports these by keeping name/address/phone consistent, but the work itself is not a build task.
- Paid search, analytics platform selection, and conversion tracking.

## Further Notes

- This is a greenfield repo. No application code of any kind exists yet — the WordPress build described in the superseded spec was never started, so the pivot costs documents rather than work.
- Domain vocabulary lives in [CONTEXT.md](../../CONTEXT.md). `Mountain Advisory` and `Regional Alert` are deliberately separate terms: the first is the client's standing seasonal guidance, the second is an official, expiring, district-scoped warning. Collapsing them reintroduces the safety over-promise the split exists to remove.
- Two things carried over untouched from the WordPress era: ADR-0002, and the domain glossary minus its custom-post-type reference.
- The sheet is a versioned deliverable, not a document the client creates. Treat schema changes with the same care as database migrations — they run against a live document containing the client's real content.
- The client is one non-technical owner, working from a phone as often as a laptop, who should be assumed to eventually reorganise the sheet. Every design choice above that looks paranoid is a response to that assumption.
