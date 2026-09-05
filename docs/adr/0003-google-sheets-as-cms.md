# Google Sheets is the CMS

The client manages all site content — Travel Packages, testimonials, page copy, settings and useful links — in a single Google Sheet, with images in a shared Drive folder. The Next.js site reads both at build time through a service account. This replaces the WordPress admin of ADR-0001: it costs the client a validating editor UI and costs us a schema we must version and migrate, but it removes WordPress, PHP hosting, plugin licences and update maintenance entirely, and puts content in a tool the client already uses.

## Consequences

- The sheet is a deliverable we build, seed, version and migrate — not something the client assembles from written instructions. It ships as a `/copy` template with a bound Apps Script, because an `.xlsx` import silently drops protection and cannot carry a script, leaving no migration path.
- A spreadsheet has no types, so validation is ours: in-sheet data validation for immediate feedback (hard-reject where the rule is certain, warn where it is a guess), plus a build-time check reporting bad rows in plain English.
- Sheet protection is advisory — the file's owner can always edit protected ranges — so the build reads columns by header name and fails loudly rather than silently shifting data.
- Schema migrations run from a custom sheet menu, versioned with `DeveloperMetadata` so the version marker cannot be deleted by the client.
