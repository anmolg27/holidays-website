# 18: Regional Alert pipeline

**What to build:** Official government warnings for a package's district, shown on the package page with their issuing authority and expiry.

The framing is the whole point. This can say "Rudraprayag is under a heavy-rain warning until 14:30." It cannot say "the Kedarnath route is open" — no public feed carries that, and implying it would be actively misleading. Present as district context with a link to the source, never as route clearance (ADR-0007).

SACHET's feed holds roughly a 10-hour window, so alerts must be polled and accumulated rather than fetched on demand.

**Blocked by:** 03

**Status:** ready-for-agent

- [ ] A cache interface with `get`/`set` and TTL exists, implemented over Workers KV, as the only Cloudflare coupling in app code (ADR-0008)
- [ ] A cron Worker polls the SACHET CAP feed on a schedule, using `If-None-Match` to avoid refetching unchanged content
- [ ] CAP XML is parsed to normalised alert objects carrying severity, issuing authority, and expiry
- [ ] District matching uses LGD geocodes where present, falling back to place-name matching for free-text location lists
- [ ] Expired alerts are dropped
- [ ] A Worker route returns `{alerts, updatedAt}` for a district
- [ ] Package pages stay static; a deferred client-side fetch populates the alert band on load
- [ ] The alert band reserves its space before the fetch resolves, so it never shifts layout
- [ ] When SACHET is unreachable, the last known-good payload is served with its timestamp rather than nothing
- [ ] Alert data is never written back to the content sheet
- [ ] The band is visibly labelled as district-level official context with a link to the source, and never as route status
- [ ] CAP parsing is unit-tested against fixtures with and without geocodes (Seam 3); the route contract is tested with the cache stubbed (Seam 2)
