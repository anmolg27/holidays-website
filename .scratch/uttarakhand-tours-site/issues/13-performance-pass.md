# 13: Performance & responsiveness pass

**What to build:** A cross-cutting hardening pass across every template built so far (03–12): image optimization (WebP delivery, lazy loading), a responsive-CSS audit, and a minimal-JavaScript audit, so the site stays fast and usable on 3G/4G mountain connections.

**Blocked by:** 03 (Single Package template), 04 (Package Archive with server-side filtering), 05 (WhatsApp integration), 06 (Lead capture forms), 07 (Interactive route map), 08 (Mountain Advisory callout), 09 (Testimonials + sitewide photo gallery), 10 (About Us & Fleet/Hotels page), 11 (Contact page), 12 (Homepage)

- [ ] Featured images and gallery images are served as WebP (or with a WebP fallback) across all templates
- [ ] Images below the fold use lazy loading across all templates
- [ ] CSS is responsive without a heavy UI framework, verified across mobile/tablet/desktop breakpoints on every page built (home, archive, single package, about, contact)
- [ ] No unnecessary JavaScript is loaded — an audit confirms JS is limited to what's functionally required (Leaflet for maps, form validation/handling), with nothing extraneous
- [ ] Page weight/load-time is spot-checked (e.g. via browser devtools network throttling to 3G/4G) on the homepage, archive, and a single package page, and judged acceptable for low-bandwidth use
