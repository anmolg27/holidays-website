# 11: Settings tab and WhatsApp integration

**What to build:** The site-wide values the client controls — WhatsApp number, phone, email, address — and the WhatsApp click-to-chat that is the primary conversion path on every package page.

**Blocked by:** 03

**Status:** ready-for-agent

- [ ] A Settings tab holds key/value rows for WhatsApp number, phone, email, and address
- [ ] Changing the WhatsApp number in one cell changes it everywhere on the site
- [ ] A persistent floating WhatsApp button appears on every package page
- [ ] An "Inquire About This Package" call to action deep-links to WhatsApp with the package title pre-filled in the message
- [ ] The deep link is correctly URL-encoded for titles containing spaces and punctuation
- [ ] Name, address, and phone render consistently sitewide for local search
- [ ] Tests assert the generated `href` including number and pre-filled title (Seam 1)
