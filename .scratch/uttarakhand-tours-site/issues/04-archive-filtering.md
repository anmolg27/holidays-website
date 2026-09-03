# 04: Package Archive with server-side filtering

**What to build:** `archive-travel_package.php`, listing packages as cards (image, title, region/theme, duration, starting price) with server-side filtering by region, theme, duration, and price via query-string parameters — no AJAX/JS-driven filtering.

**Blocked by:** 02 (ACF field schema for Travel Package + acf-json export)

- [ ] `archive-travel_package.php` lists all published `travel_package` posts as cards showing featured image, title, region/theme, duration, and starting price
- [ ] Filtering by `package_region` term via a query parameter returns only matching packages
- [ ] Filtering by `package_theme` term via a query parameter returns only matching packages
- [ ] Filtering by duration range/value via a query parameter returns only matching packages
- [ ] Filtering by price range via a query parameter returns only matching packages
- [ ] Multiple filters can be combined in a single request (e.g. region + theme + price) and results reflect the intersection
- [ ] Filter results render as a normal server-rendered page load — no JavaScript is required to see filtered results
- [ ] An integration test seeds multiple packages with varying region/theme/duration/price values and asserts that filtered queries return exactly the expected subset for several filter combinations
