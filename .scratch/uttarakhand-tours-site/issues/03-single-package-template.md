# 03: Single Package template (full content)

**What to build:** `single-travel_package.php`, rendering the full package detail page from the fields in ticket 02 — itinerary, inclusions/exclusions, pricing, hotel tier, meal plan, vehicle options, and gallery. Map, advisory callout, WhatsApp, and lead-capture forms are explicitly out of scope for this ticket (tickets 05–08).

**Blocked by:** 02 (ACF field schema for Travel Package + acf-json export)

- [ ] `single-travel_package.php` renders the package title, featured image, and gallery
- [ ] Renders `package_price` (as `₹`-prefixed "starting from" value), `package_duration`, and `pickup_drop_location`
- [ ] Renders `vehicle_options`, `driver_allowance_included`, `toll_parking_included`
- [ ] Renders `hotel_tier` and `meal_plan`
- [ ] Renders `itinerary_content`, `inclusions`, and `exclusions`
- [ ] Renders assigned `package_region` and `package_theme` terms
- [ ] Page is reachable at the CPT's standard single-post URL and returns a 200 response for a published package
- [ ] An integration test seeds a `travel_package` with representative field values and asserts each piece of data above appears in the rendered HTML
