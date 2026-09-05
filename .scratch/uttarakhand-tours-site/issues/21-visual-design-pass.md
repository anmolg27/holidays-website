# 21: Visual design pass

**What to build:** The coherence pass across the finished site. Ticket 02 established the foundation and every page was built against it; this is where the whole thing is judged together and made to feel like one considered product rather than twenty tickets.

For a travel company asking families to trust it with a Char Dham trip, looking credible is a conversion requirement, not decoration.

Use the `impeccable` skill for this ticket — its `audit`, `critique` and `polish` playbooks are the shape of this work. Judge the site against `DESIGN.md` from ticket 02; where a page has drifted from that direction, the direction wins unless there is a reason to change `DESIGN.md` itself.

**Blocked by:** 04, 07, 12, 13, 14, 17, 18

**Status:** ready-for-agent

- [ ] Every page is reviewed together for consistent hierarchy, rhythm, and spacing
- [ ] The site reads as an Uttarakhand regional specialist, not a generic travel template
- [ ] Package cards are visually consistent, so differences between packages stand out rather than differences in layout
- [ ] Price, duration, itinerary, and inclusions have clear hierarchy on the package page
- [ ] Empty, loading, and error states are designed, not defaults — including no packages matching a filter, a package with no gallery, and alerts failing to load
- [ ] Every page verified at phone, tablet, and desktop widths with no horizontal scroll
- [ ] WCAG AA contrast holds across the final palette; focus states are visible everywhere
- [ ] Motion is purposeful and respects `prefers-reduced-motion`
- [ ] Core Web Vitals still meet thresholds after the pass — polish must not cost the page
- [ ] Automated accessibility checks pass on every page type
- [ ] `DESIGN.md` is updated to match what actually shipped, so it stays the source of truth rather than a stale artifact
