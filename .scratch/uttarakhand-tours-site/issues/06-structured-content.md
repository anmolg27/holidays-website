# 06: Structured content — itinerary, inclusions, Route Stops

**What to build:** The parts of a Travel Package that aren't a single value: the day-wise itinerary, the inclusions and exclusions lists, and the ordered Route Stops. This establishes the multi-tab join pattern the rest of the schema follows.

Route Stops accept a pasted Google Maps URL rather than typed coordinates — hand-typed latitude and longitude is the most error-prone possible input from a non-technical editor, and a wrong link is visibly wrong when clicked whereas a wrong number is not.

**Blocked by:** 03

**Status:** ready-for-agent

- [ ] Itinerary days live in their own tab, one row per day, joined to the package by `package_slug`
- [ ] Route Stops live in their own tab, one row per stop, ordered, joined the same way
- [ ] Inclusions and exclusions are newline-separated within a single cell and render as lists
- [ ] A pasted Google Maps URL is parsed to coordinates at build time, across the URL shapes clients actually paste
- [ ] An unparseable Maps URL names the offending row and column and skips that stop rather than failing the build
- [ ] The package detail page renders the full itinerary, inclusions, and exclusions
- [ ] Maps URL parsing is unit-tested in isolation (Seam 3)
