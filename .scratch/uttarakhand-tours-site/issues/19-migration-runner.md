# 19: Schema migration runner

**What to build:** How new fields reach a sheet already living in the client's Drive, full of their real content, without clobbering any of it.

Treat this with the care of a database migration, because that is what it is — it runs against a live document holding the client's work.

**Blocked by:** 08

**Status:** ready-for-agent

- [ ] Schema version is stored in `DeveloperMetadata`, not a cell, so the client cannot delete it
- [ ] A menu item runs pending migrations in order and reports what changed
- [ ] Migrations are additive and idempotent: safe to run twice, never reordering or deleting the client's columns or data
- [ ] Missing headers are appended by name; existing content is untouched
- [ ] Columns are tagged with `DeveloperMetadata` at creation, so a renamed header is not mistaken for a deleted column
- [ ] New tabs are created only if absent
- [ ] The client is told plainly what changed and whether they need to do anything
