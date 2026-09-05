# 12: Lead capture end to end

**What to build:** A visitor submits any of the three forms and the owner gets an email they can reply to, plus a durable row in a Leads tab of the sheet they already work in.

The route handler is not ceremony: it keeps the Apps Script URL out of the browser bundle and is the only place origin checks, rate limiting, and Turnstile can run, because Apps Script cannot see a caller's IP or origin (ADR-0006).

**Blocked by:** 08, 11

**Status:** ready-for-agent

- [ ] Three forms exist: per-package inquiry, Custom Package Request, and Contact — sharing one endpoint, discriminated by a form-type field
- [ ] The per-package form captures travel date, passenger count, and preferred vehicle, and carries the package it came from
- [ ] The Custom Package Request captures region, dates, passenger count, vehicle preference, accommodation tier, and notes
- [ ] Forms make clear the visitor is requesting a quote or callback, never completing a booking
- [ ] The route handler validates input, verifies a Cloudflare Turnstile token, and rate-limits before forwarding
- [ ] An Apps Script web app appends the Lead to a Leads tab, **then** emails the owner — so an exhausted quota never loses a lead
- [ ] `MailApp.getRemainingDailyQuota()` is checked and the send skipped rather than throwing
- [ ] `replyTo` is the lead's email address, so the owner replies directly from Gmail
- [ ] `doPost` is wrapped in try/catch and returns `{ok, error}` JSON; the route handler translates it into real HTTP statuses
- [ ] The Apps Script call runs in `ctx.waitUntil()` so its latency is off the visitor's critical path
- [ ] The visitor sees clear confirmation, and a failure never looks like a success
- [ ] No form computes or displays a price
- [ ] Tests cover the handler's request/response contract with Apps Script, cache, and Turnstile stubbed (Seam 2)
