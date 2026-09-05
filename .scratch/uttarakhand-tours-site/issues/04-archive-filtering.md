# 04: Package archive with server-side filtering

**What to build:** A browsable archive of Travel Packages that a visitor can narrow by Package Region, Package Theme, duration, and starting price. Filtering happens on the server via query-string parameters and produces a normal page load, so results are visible with JavaScript disabled.

**Blocked by:** 03

**Status:** ready-for-agent

- [ ] Package Region and Package Theme exist in the schema as taxonomies, open for the client to extend with new terms
- [ ] An archive page lists published packages as cards showing image, title, region, theme, duration, and starting price
- [ ] Filtering by region, theme, duration, and price works through query-string parameters
- [ ] Results render server-side; the page is fully usable with JavaScript disabled
- [ ] Filters combine correctly, and an empty result set renders a helpful state rather than a blank page
- [ ] Tests assert correct packages are included and excluded for each filter and combination (Seam 1)
