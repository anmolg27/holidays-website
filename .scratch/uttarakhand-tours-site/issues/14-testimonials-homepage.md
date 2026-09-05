# 14: Testimonials and homepage

**What to build:** The homepage — the page that decides whether a visitor stays. Featured packages, popular regions, trust signals, and real testimonials with names and photos.

Note: testimonials are displayed but deliberately carry no `AggregateRating` or `Review` structured data (ADR-0009).

**Blocked by:** 04, 05

**Status:** ready-for-agent

- [ ] A Testimonials tab holds reviewer name, quote, and photo filename
- [ ] Testimonial photos come from the Drive folder like all other images
- [ ] The homepage renders featured packages, entry points to each Package Region, trust signals, and testimonials
- [ ] Which packages are featured is controllable from the sheet, not hardcoded
- [ ] The homepage works and looks right at phone widths
- [ ] The homepage meets Core Web Vitals thresholds, including no layout shift from the hero
