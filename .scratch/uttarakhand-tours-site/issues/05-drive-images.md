# 05: Images from Google Drive

**What to build:** Package photography, managed by the client dropping files into a shared Drive folder and naming them in the sheet. The build fetches, optimises, and serves them — so the client adds photos without a developer and without a second account.

**Blocked by:** 03

**Status:** ready-for-agent

- [ ] The Drive folder is shared with the same service account used for the sheet
- [ ] The build downloads images referenced by the sheet via the Drive API
- [ ] Images are resized to responsive sizes and served as WebP with explicit width and height
- [ ] Featured image renders on package cards and the package detail page
- [ ] A gallery renders on the package detail page
- [ ] A missing or renamed file produces a clear, named error rather than a broken build or a silently missing image
- [ ] Images are lazy-loaded below the fold and do not cause layout shift
