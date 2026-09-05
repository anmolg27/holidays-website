# 15: SEO core

**What to build:** The search-visibility surface. This site has no other acquisition channel — organic search for queries like "char dham tour package" is the business — so this is a conversion requirement, not a technical nicety.

**Blocked by:** 04, 05

**Status:** ready-for-agent

- [ ] `meta_title` and `meta_description` are optional sheet columns; when blank the build generates them from title, region, duration, and price
- [ ] No page is ever published with an empty or duplicated title
- [ ] Every indexable page carries an absolute, self-referencing canonical
- [ ] Single-facet archives — one region, or one theme — are indexable and carry their own intro copy from the sheet
- [ ] Multi-facet combinations and all price/duration filters are `noindex` with a canonical to the nearest indexable parent (ADR-0009)
- [ ] JSON-LD emits `TouristTrip` per package, `TravelAgency` for the organisation, and `BreadcrumbList` on package and archive pages
- [ ] No `AggregateRating` or `Review` markup is emitted anywhere (ADR-0009)
- [ ] Open Graph and Twitter Card tags render on every page, so a package link pasted into WhatsApp shows a rich preview
- [ ] `sitemap.xml` and `robots.txt` are generated at build from the content repository, with `lastmod` per page
- [ ] Image alt text comes from a gallery column, falling back to a generated value
- [ ] Tests assert generated metadata, canonicals, `noindex` placement, JSON-LD validity, and sitemap contents matching exactly the published set (Seam 1)
