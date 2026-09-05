# 07: Route map

**What to build:** A map on the package detail page showing the journey's key stops in order, so a traveler understands the trip geographically.

This is deliberately not a road-following route. It plots approximate waypoints, and the UI must not imply otherwise.

**Blocked by:** 06

**Status:** ready-for-agent

- [ ] Leaflet renders with OpenStreetMap tiles — no API key, no billing account
- [ ] Route Stops render as ordered, labelled markers joined by straight waypoint lines
- [ ] The map is usable on a phone and does not trap page scroll
- [ ] The map does not cause layout shift as it initialises
- [ ] A package with no Route Stops renders the page without a broken or empty map
- [ ] Map JavaScript loads only on pages that have a map
