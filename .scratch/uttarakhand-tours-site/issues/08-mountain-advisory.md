# 08: Mountain Advisory callout

**What to build:** A callout section on the single package page rendering the package's manually-written Mountain Advisory content (road conditions, monsoon/weather updates, permit requirements, recommended gear). No live external data source — confirmed no public API/feed exists (USDMA/PWD sources checked).

**Blocked by:** 02 (ACF field schema for Travel Package + acf-json export), 03 (Single Package template)

- [ ] Single package page renders a visually distinct callout/section for the Mountain Advisory content when present
- [ ] The callout displays whatever the client has entered for road conditions, monsoon/weather updates, permit requirements, and recommended gear
- [ ] The callout is omitted or shows a sensible empty state when no advisory content has been entered for a package
- [ ] No network call to any external weather/disaster-advisory service is made — content is entirely from the package's own field data
- [ ] An integration test seeds a package with advisory content and asserts it appears in the rendered page; seeds another with no advisory content and asserts the empty state behaves as expected
