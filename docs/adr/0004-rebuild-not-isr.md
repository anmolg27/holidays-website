# Content updates by full rebuild, not ISR

Sheet content reaches the site only through a full rebuild, which the client triggers from a menu button inside the sheet itself. We deliberately do not use ISR or on-demand revalidation for sheet content, despite both being well-supported and faster.

The build is the validation gate between a non-technical editor and production: it checks every row at once, optimises Drive images, and fails safely to the last good deploy. ISR removes that gate — a malformed cell would reach live within seconds as a broken page instead of a build report. The build step is the feature, not the cost.

A weekly cron build also runs, but as a pipeline canary rather than a content mechanism: it proves credentials and dependencies still work on a day nobody is waiting, instead of the moment the client urgently needs to publish. Regional Alert data is exempt from this decision — it is a separate source with its own freshness path.
