# 07: Interactive route map (Leaflet/OSM)

**What to build:** An interactive map on the single package page, built with Leaflet + OpenStreetMap (no API key, no billing account), plotting the package's Route Stops as markers connected by straight waypoint lines — not a road-following route.

**Blocked by:** 02 (ACF field schema for Travel Package + acf-json export), 03 (Single Package template)

- [ ] Leaflet is included as the mapping library, tiled from OpenStreetMap, with no Google Maps API key or billing dependency anywhere
- [ ] The single package page renders a map showing markers for each of the package's Route Stops, in order
- [ ] Markers are connected by a simple waypoint line (not a routed/road-following path)
- [ ] Map is interactive (pan/zoom) and gracefully renders nothing (no broken map) when a package has no Route Stops set
- [ ] Map loading does not block or significantly delay the rest of the page's content
- [ ] An integration test seeds a package with a known set of Route Stops and asserts the rendered page includes the expected marker data (place names/coordinates) in the format the map script consumes
