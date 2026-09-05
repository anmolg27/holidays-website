# 03: Travel Package from sheet to live page

**What to build:** The tracer bullet. A Travel Package row in a Google Sheet renders as a live package detail page. Editing a cell and rebuilding changes what visitors see.

This establishes the content repository interface that every later ticket reads through, and the domain schema that the sheet builder later walks. Per ADR-0008, nothing downstream of the repository may see a row, a tab, or a header name.

**Blocked by:** 01, 02

**Status:** ready-for-agent

- [ ] A service account reads the sheet with `spreadsheets.readonly`; the sheet is shared with its address
- [ ] A domain schema defines Travel Package fields, types, and required-ness, independent of Google Sheets
- [ ] A Sheets binding maps those fields to tab and column, separate from the domain schema
- [ ] A content repository interface exposes `getPackages()` and `getPackage(slug)` returning domain objects
- [ ] The Google Sheets implementation sits behind that interface and its types do not escape it
- [ ] Columns are located by header name, never by position
- [ ] A package detail page renders the flat fields: title, starting price in `₹`, duration, pickup/drop, hotel tier, meal plan, vehicle options, driver allowance and toll/parking inclusion
- [ ] Rows with `Publish` not TRUE are excluded from the build output
- [ ] Tests feed fixture Sheets API responses and assert on rendered output (Seam 1)
