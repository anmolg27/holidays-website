---
version: 1
slug: "wp-content-themes-uttarakhand-tours-front-page-php"
primary_target: "wp-content/themes/uttarakhand-tours/front-page.php"
related_targets: ["wp-content/themes/uttarakhand-tours/archive-travel_package.php","wp-content/themes/uttarakhand-tours/single-travel_package.php","wp-content/themes/uttarakhand-tours/page.php","wp-content/themes/uttarakhand-tours/page-contact.php"]
---

## Scope

Sitewide visual world for Uttarakhand Tours — home (front-page.php), archive (archive-travel_package.php), single package (single-travel_package.php), About/Fleet (page.php), Contact (page-contact.php). Mode: Persuade across all five (visitor decides to inquire; design is the product).

## Audience, job, action, proof, constraints

Travelers planning a Char Dham pilgrimage, trek, honeymoon, family, or weekend Uttarakhand trip, browsing on a phone over patchy mountain-adjacent mobile data, deciding whether to trust this local operator over a generic OTA. Their job: find a package or submit an inquiry. Action: WhatsApp click-to-chat or an inquiry form — never a payment/booking flow (ADR-0002). Proof: real package details (price, duration, region/theme, vehicle, hotel tier) — no invented testimonials or stock claims (none exist yet, per PRODUCT.md's Evidence on Hand). Constraints: system stack for body/UI text, one self-hosted (no third-party CDN) display face for headings (ADR-0003), WebP + lazy-loaded images, CF7/Leaflet assets already scoped to only the pages that need them (ticket 13) — the design must not regress any of this.

## Chosen direction and memorable moment

Prayer-Flag Trail — the repeating flag-band rule as the site's signature graphic device; a visitor should remember the site as "the one with the flag-string bands," not a generic travel-agency template.

## Unresolved decisions

Exact palette hex values, type scale, and per-page composition are resolved during build, not here. Real package/gallery/testimonial photography does not exist yet — every image-bearing section needs a tasteful placeholder treatment (a flag-band-motif fill, not a generic gray box) until the client uploads real photos.

## Direction contract

THESIS: Every touchpoint reads as a string of prayer flags along a mountain route — repeating color-blocked bands mark passage and progress, refusing the generic OTA card-grid-on-white default.

OWN-WORLD: Traditional 5-flag palette (sky-blue, cloud-white, flame-red, leaf-green, sun-yellow) as a Full-palette strategy, used as thin repeating bands and section dividers only, never competing blocks. Warm hemp-paper ground. Lora (self-hosted, Latin subset, single weight, `font-display: swap`) as the display face for headings — swapped from an initial Fraunces choice after the mechanical detector flagged it as an overused AI-generated-UI default; the system stack for body/UI text (ADR-0003).

STORY: A first-time visitor feels warmth and regional specificity immediately, scans packages as a "string" of options, and reaches the operator directly without hunting.

FIRST VIEWPORT: warm hemp-toned hero, a repeating flag-band rule beneath the nav as the signature graphic device, "Discover Uttarakhand" in the display face, region/theme filter directly below as the primary action. No stock photography — typography + band rule carry identity until real photos arrive.

FORM: assigned index 7 of the grounded candidate list ("prayer flag strings & woven pattern textiles"), raised by: (1) an advisory/permit-stamp motif donated from a declined hazard-signage challenger — Mountain Advisory renders as an ink-stamp badge; (2) a rhythm-as-signal discipline donated from a declined op-art-gallery challenger — the flag-band rule's density varies meaningfully (denser near featured content, calmer elsewhere), never decorative filler; (3) procession pacing donated from a competitive kinetic-paper-automata challenger — Route Stops and Itinerary read as a step-by-step journey. Seed key: e649fc9d.

FINISH: unreviewed and undocumented is unfinished; this build ends with the finish review, the verdict, DESIGN.md, and every shipping raster carrying its provenance.
