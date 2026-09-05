# 17: Useful Links

**What to build:** Links to official weather and disaster advisory sources on package pages, scoped so travelers see what's relevant to their region.

This is where the sources rejected for parsing belong. IMD's Char Dham sector portal and the Uttarakhand PWD road-closure dashboard are genuinely useful to a traveler and genuinely too fragile to scrape — a dead link is visible to whoever clicks it, whereas a broken scraper fails silently and wrongly (ADR-0007).

**Blocked by:** 04

**Status:** ready-for-agent

- [ ] A Useful Links tab holds label, URL, scope, and enabled flag
- [ ] Scope is either `global` or a Package Region, and packages show global links plus their region's
- [ ] Seeded with SACHET, IMD Uttarakhand, PWD road closures, and USDMA globally; IMD Char Dham portal and yatra registration for Char Dham; GSI landslide bulletin for Rudraprayag
- [ ] The client can add, edit, disable, and fix links without a developer
- [ ] Links open in a new tab and are clearly marked as external official sources
