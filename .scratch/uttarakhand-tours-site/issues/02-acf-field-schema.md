# 02: ACF field schema for Travel Package + acf-json export

**What to build:** The full ACF (free) field group for `travel_package`, covering pricing/duration, transportation, accommodation, itinerary/inclusions/exclusions, Route Stops, and Mountain Advisory text — synced via `acf-json` so the field schema travels with the theme across environments.

**Blocked by:** 01 (Theme scaffold + Travel Package CPT & taxonomies)

- [ ] ACF (free) is set up as a dependency and its field group(s) are exported to `acf-json` (or an equivalent PHP export) checked into the theme, so fields exist automatically on any environment without manual re-creation
- [ ] `package_price` field (single flat starting-from value, plain number/text — no computed/derived pricing logic anywhere)
- [ ] `package_duration` field (e.g. "5 Days / 4 Nights")
- [ ] `pickup_drop_location` field
- [ ] `vehicle_options` field (select/multi-select: Sedan, SUV/Innova, Tempo Traveller)
- [ ] `driver_allowance_included` field (true/false)
- [ ] `toll_parking_included` field (true/false)
- [ ] `hotel_tier` field (Standard, Deluxe, Luxury)
- [ ] `meal_plan` field (EP, CP, MAP)
- [ ] `itinerary_content` field (WYSIWYG or structured day-wise content)
- [ ] `inclusions` and `exclusions` fields (WYSIWYG or list)
- [ ] Route Stops field: a repeatable place-name + coordinate pair, with no assumptions baked in about a future live-routing data source
- [ ] Mountain Advisory field(s): manually-editable text covering road conditions, monsoon/weather updates, permit requirements, recommended gear — no external data source wired in
- [ ] A native WordPress gallery is usable per package (core gallery block or native attachment field — no ACF repeater needed for this)
- [ ] All fields are visible and editable on the `travel_package` edit screen in wp-admin, and save/reload correctly
- [ ] An integration test seeds a `travel_package` with values for every field above and asserts they persist and are retrievable via the standard field-access API
