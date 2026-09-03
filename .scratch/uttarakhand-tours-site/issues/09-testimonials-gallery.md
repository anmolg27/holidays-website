# 09: Testimonials + sitewide photo gallery

**What to build:** A manually-entered testimonials mechanism (reviewer name, photo, quote) and a sitewide/homepage photo gallery section that aggregates images from all packages' existing native galleries — no separate photo upload step for the client.

**Blocked by:** 02 (ACF field schema for Travel Package + acf-json export)

- [ ] Testimonials are manageable by the client in wp-admin (a CPT or ACF repeater), with fields for reviewer name, photo, and quote text
- [ ] A reusable template part/function outputs a list of testimonials, suitable for embedding on the homepage
- [ ] A sitewide gallery section aggregates images pulled from all published packages' native galleries (from ticket 02) with no separate upload mechanism
- [ ] Both sections render correctly when there is existing content, and degrade gracefully (no errors, sensible empty state) when there are zero testimonials or zero package gallery images
- [ ] An integration test seeds testimonials and package gallery images and asserts both render in their respective outputs; asserts graceful behavior with none seeded
