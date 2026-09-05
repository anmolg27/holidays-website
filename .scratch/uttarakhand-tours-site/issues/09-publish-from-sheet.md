# 09: Publish from the sheet

**What to build:** The client publishes the website by clicking a menu item inside the spreadsheet they're already working in. No second tool, no second login, no URL to keep secret.

Note this must be a custom menu item or an installable trigger — a simple `onEdit` trigger cannot call an external service, because simple triggers cannot use services requiring authorization.

**Blocked by:** 01, 08

**Status:** ready-for-agent

- [ ] A custom menu appears in the sheet on open
- [ ] A menu item POSTs to a Cloudflare deploy hook and triggers a full rebuild
- [ ] The client sees confirmation that publishing started, and is not left guessing
- [ ] The deploy hook URL is held as a script property, never in a cell or in client-visible code
- [ ] Repeated clicks do not queue redundant builds
- [ ] Written instructions cover updating the script via Manage deployments → Edit, never New deployment, which would mint a new URL and silently break the integration
