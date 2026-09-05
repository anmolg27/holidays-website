---
status: superseded by ADR-0003
---

# Classic PHP theme, not a block/FSE theme

We're building a custom classic WordPress theme (`functions.php`, `archive-travel_package.php`, `single-travel_package.php`, `front-page.php`) rather than a Full Site Editing block theme. The `travel_package` CPT needs custom archive/single layouts (filters, pricing, route maps, advisory callouts) that are more directly expressed as hand-written PHP templates than as FSE block templates + `theme.json`. The block editor is still used for in-content editing within these templates, but there's no Site Editor / full-site-editing layer. Switching to FSE later means rebuilding the template layer from scratch, not a configuration change.
