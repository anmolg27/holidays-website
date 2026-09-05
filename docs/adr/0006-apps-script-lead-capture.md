# Lead capture through Apps Script, not an email vendor

Forms post to a Next.js route handler, which forwards to a Google Apps Script web app bound to the content sheet. The script appends the Lead to a Leads tab, then emails the owner via `MailApp`.

We deliberately did not use a transactional email vendor. At this volume the notification is one Gmail account emailing another: no domain verification, no DNS records, and no vendor account that can be repriced or withdrawn — SendGrid retired its free tier in 2025, which is the general risk in miniature. Leads also land in the tool the client already works in.

## Consequences

- `MailApp` always sends from the script owner's Google account, capped at 100 recipients/day on a consumer account. Append the Lead *before* sending, so an exhausted quota never loses one.
- The route handler is not ceremony: it keeps the script URL out of the browser bundle and is the only place origin checks, rate limiting and Turnstile can run, because Apps Script cannot see a caller's IP or origin.
- Apps Script cannot set HTTP status codes, so the script returns `{ok, error}` JSON and the route handler translates it. `doPost` must be wrapped in try/catch or an uncaught error returns an HTML page that fails JSON parsing confusingly.
- A branded auto-reply *to the customer* would need either Google Workspace or moving the email leg to a vendor. The sheet append stays either way.
