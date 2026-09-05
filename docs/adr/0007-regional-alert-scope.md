# Regional Alert is district-scoped, client-fetched, and single-source

Package pages show official government warnings from the SACHET/NDMA CAP feed, polled into Cloudflare KV by a cron worker and fetched client-side on page load. Three choices here are deliberate, and each is one a later reader will be tempted to reverse.

**District-scoped, never route-scoped.** No public feed states whether a Char Dham route is open — that call travels by district magistrate order, press note and WhatsApp. Alerts are presented as regional context with their issuing source and expiry, never as route clearance. This is why `Mountain Advisory` and `Regional Alert` are separate terms in CONTEXT.md.

**SACHET only.** IMD's Char Dham sector portal and the Uttarakhand PWD road-closure dashboard are more route-shaped, but both are unversioned HTML that would break silently and need a developer. They are linked to instead of parsed. IMD's official API bars commercial reproduction, India's NCS seismic data is non-commercial and has no API, GDACS pads events to a ±4° box roughly 900km across, and data.gov.in has no live road or hazard feed. SACHET is keyless, declares itself public domain, and honours a documented ETag/304 contract.

**Client-side, so visitors without JavaScript see no alert.** Accepted knowingly, against this site's own low-bandwidth goals, because alerts supplement the client-written Mountain Advisory rather than replacing it.

Alerts are cached in KV rather than written back to the content sheet: per-pageview sheet writes would exhaust a 60/minute quota, race under concurrency, and put a machine-writing process inside the client's validated schema. KV holds the last known-good payload with its timestamp, so a SACHET outage degrades to stale-but-dated rather than empty.
