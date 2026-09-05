# 10: Build validation and the client error report

**What to build:** What happens when the client types something wrong. The build distinguishes damage from mistakes, keeps the live site safe, and tells a non-technical person exactly what to fix in language they can act on.

The critical property: a failed publish means the client sees the site **not update**, which is silent. The report is the only mechanism by which they learn something is wrong, so it is load-bearing rather than a nicety.

**Blocked by:** 06, 08

**Status:** ready-for-agent

- [ ] Structural damage — a missing tab or column — fails the entire build
- [ ] Row-level errors skip the offending row and the build continues
- [ ] A failed build leaves the previous deploy serving; visitors never see a broken site
- [ ] A report is emailed to both the client and the developer after every build that had problems
- [ ] The report names row and column in plain English, e.g. `Row 7, 'Starting Price': expected a number, found '15,000/- onwards'` — never a raw validation-library error
- [ ] The report states plainly whether the site updated or not
- [ ] Tests assert the report's wording against fixtures containing deliberately broken rows (Seam 1)
