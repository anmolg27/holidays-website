# 08: Sheet template, schema builder, and seed content

**What to build:** The client-facing deliverable. A Google Sheet we construct, validate, seed, and hand over as a `/copy` link — not a schema the client assembles from instructions.

A bound Apps Script builds the sheet by walking the declarative schema, so every later ticket that adds a column gets sheet-building for free. Keep the script dumb: it walks data, it does not contain logic (ADR-0003, ADR-0008).

Delivery is a `/copy` link, not an `.xlsx` import — an import silently drops protection and cannot carry a script, which would leave no migration path.

**Blocked by:** 06

**Status:** ready-for-agent

- [ ] A bound Apps Script constructs every tab, header row, and column from the schema definition
- [ ] Data validation is applied from the schema: hard-reject on region, theme, price, duration and dates; warn-only on Maps URLs and image filenames
- [ ] Conditional formatting highlights incomplete rows
- [ ] Header rows are protected with `setWarningOnly(true)`, and frozen
- [ ] The sheet is seeded with 5–6 plausible Uttarakhand packages spanning both taxonomies, every one at `Publish = FALSE`
- [ ] Seeded content includes itinerary days, Route Stops, and gallery rows so every tab demonstrates its format
- [ ] The template is distributable as a `/copy` link that preserves validation, formatting, protection, and the bound script
- [ ] Adding a field to the schema definition changes the built sheet with no other edit
