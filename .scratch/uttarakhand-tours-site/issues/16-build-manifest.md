# 16: Build manifest, slug stability, and 410

**What to build:** The build's memory of what it published last time. Without it, a client renaming a package title silently 404s an indexed page and discards its ranking, and an unpublished package leaves a URL search engines re-crawl for weeks.

**Blocked by:** 15

**Status:** ready-for-agent

- [ ] `slug` is an explicit sheet column, authored once and independent of the package title
- [ ] A manifest of published slugs persists between deploys
- [ ] The build **fails** when a slug changes, naming the package and both slugs, rather than silently publishing a new URL
- [ ] Deliberately changing a slug is supported through an explicit, documented path
- [ ] A URL for a package that was published and is now unpublished returns **410 Gone**, not 404
- [ ] The 410 response is a helpful page pointing to the relevant region archive, not a bare status
- [ ] Tests render two fixture generations and assert the build fails on a changed slug (Seam 1)
