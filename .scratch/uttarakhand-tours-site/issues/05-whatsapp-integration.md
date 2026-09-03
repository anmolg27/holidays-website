# 05: WhatsApp integration

**What to build:** A single site-wide WhatsApp number setting, consumed by a persistent floating click-to-chat button on every package page and a per-package "Inquire About This Package" CTA that pre-fills the package title into the WhatsApp deep-link message.

**Blocked by:** 03 (Single Package template)

- [ ] The WhatsApp number is stored as one site-wide value (e.g. Customizer setting or theme option), not hardcoded in multiple templates
- [ ] A floating WhatsApp click-to-chat button appears on every `travel_package` single page
- [ ] A distinct "Inquire About This Package" CTA appears on the package page and generates a WhatsApp deep link that pre-fills the specific package's title into the chat message
- [ ] Both the floating button and the CTA link use the same site-wide number and update together if the number is changed
- [ ] An integration test seeds a package with a known title and a known configured WhatsApp number, then asserts the generated `href` for both the floating button and the CTA contains the correct number and the correctly pre-filled package title
