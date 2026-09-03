# 01: Theme scaffold + Travel Package CPT & taxonomies

**What to build:** A minimal, activatable classic WordPress theme (per ADR-0001) with the `travel_package` custom post type and the `package_region` / `package_theme` taxonomies registered in code. No ACF fields, no custom templates beyond WordPress defaults yet — this ticket only establishes the foundation everything else builds on.

**Blocked by:** None (can start immediately)

- [ ] Theme has `style.css` (with theme header), `functions.php`, and activates cleanly with no PHP errors/warnings
- [ ] `travel_package` CPT is registered in code (not via a plugin), with support for title, editor, thumbnail, and archive enabled
- [ ] `package_region` taxonomy registered (hierarchical or non-hierarchical per WordPress taxonomy norms), assignable to `travel_package`, with initial terms: Garhwal, Kumaon, Char Dham, Border circuits
- [ ] `package_theme` taxonomy registered, assignable to `travel_package`, with initial terms: Pilgrimage, Trekking, Honeymoon, Family, Weekend
- [ ] Both taxonomies are editable/addable by users with standard content-management capabilities via wp-admin (not restricted to a fixed list)
- [ ] A `travel_package` post can be created, published, and assigned region/theme terms through wp-admin
- [ ] Visiting the CPT's default archive URL and a single post's default URL renders without errors (default WordPress template output is acceptable at this stage)
- [ ] An integration test (per the spec's testing seam) confirms the CPT and both taxonomies are registered with the expected names, labels, and post-type associations
