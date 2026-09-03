# 12: Homepage

**What to build:** `front-page.php` with a hero search/filter bar (submitting into the archive's server-side filtering), featured packages, popular regions, trust badges, and a testimonials/gallery teaser.

**Blocked by:** 04 (Package Archive with server-side filtering), 09 (Testimonials + sitewide photo gallery)

- [ ] `front-page.php` renders a hero section with a search/filter bar for region and travel theme
- [ ] Submitting the hero filter bar navigates to the package archive (ticket 04) with the corresponding filter query parameters applied, returning correctly filtered results
- [ ] A "featured packages" section displays a curated or most-recent set of `travel_package` posts as cards
- [ ] A "popular regions" section links out to the archive pre-filtered by each region
- [ ] Trust badges (e.g. verified drivers, sanitized cabs — static/editable content) are displayed
- [ ] A testimonials/gallery teaser section (from ticket 09) is embedded on the homepage
- [ ] An integration test confirms the homepage renders all sections above with expected data, and that the hero filter bar's generated links match the archive's expected query parameter format
