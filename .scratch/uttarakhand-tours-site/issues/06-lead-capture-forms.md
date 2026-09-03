# 06: Lead capture forms

**What to build:** Two Contact Form 7 forms — a per-package inquiry form (travel date, passenger count, preferred vehicle) placed on the single package page, and a standalone Custom Package Request form (region, travel dates, passenger count, vehicle preference, accommodation tier, notes) usable independently of any specific package. Neither form computes or displays a price.

**Blocked by:** 02 (ACF field schema for Travel Package + acf-json export), 03 (Single Package template)

- [ ] Contact Form 7 (free) is set up as a dependency
- [ ] Per-package inquiry form appears on the single package page, with fields for travel date, passenger count, and preferred vehicle, and a hidden/prefilled reference to the package being inquired about
- [ ] Standalone Custom Package Request form exists (embeddable on any page) with fields: region (populated from `package_region` terms), travel dates (start date + duration), passenger count, vehicle preference, accommodation tier, and free-text notes
- [ ] Neither form displays or calculates a price at any point — submission is confirmed as a request/inquiry, not a booking
- [ ] Submitting either form (with valid data) succeeds and the submission is receivable (e.g. via email notification, matching standard Contact Form 7 behavior)
- [ ] An integration/functional test confirms both forms render with all required fields present, and that the per-package form's package reference matches the package it's embedded on
