# Two portability seams, and no others

Content is reached only through a content repository interface returning domain objects (Travel Package, Testimonial, Settings), and cached state only through a small cache interface with `get`/`set` and a TTL. Google Sheets and Cloudflare KV are implementations behind those interfaces, and their types never escape past them.

These two exist because we can name their second implementation — Postgres and Redis respectively. Nothing else gets an interface on speculation: the image source, form backend, alert source and hosting target stay concrete, because nobody can name a second one.

The sheet schema splits along the same line. A **domain schema** defines what a Travel Package is — fields, types, required-ness — and is source-agnostic; it validates rows today and would generate the table definitions after a migration. A **Sheets binding** maps those fields to tabs, columns and in-sheet validation rules, and is discarded on migration. Both the build validator and the Apps Script sheet builder read from these, so a new field is a one-file change rather than three that drift.

## Consequences

- Pages, components and rendering never see a row, a header name, or a tab. A source swap rewrites one module.
- The Apps Script stays thin enough to need no tests, because it walks a declarative schema rather than containing logic.
- This does not make a Postgres migration free. Moving off Sheets would likely also mean moving from build-time reads to runtime queries with ISR, reopening ADR-0004. The seam means pages don't change when that happens; it does not mean nothing changes.
