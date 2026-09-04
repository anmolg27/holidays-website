# Uttarakhand Tours

A lead-generation website for an Uttarakhand-focused tour company, showcasing curated travel packages that combine cab transportation, hotel accommodation, and guided itineraries across Garhwal, Kumaon, and Char Dham.

The site converts visitors into **inquiries, not bookings**. There is no online payment, no checkout, and no availability calendar — every trip is confirmed with the traveller directly by phone or WhatsApp. See [ADR-0002](docs/adr/0002-lead-generation-only.md) for why, and [CONTEXT.md](CONTEXT.md) for the project's vocabulary (Travel Package, Lead, Mountain Advisory, and so on).

It is a **classic (non-FSE) WordPress theme** rather than a block theme — see [ADR-0001](docs/adr/0001-classic-php-theme.md).

---

## Requirements

| Tool | Notes |
| --- | --- |
| [Docker](https://www.docker.com/products/docker-desktop/) | Must be running. `wp-env` builds the whole WordPress stack in containers. |
| Node.js 18+ | Only used to run `@wordpress/env`. |
| Composer | Dev/test dependencies only. If you'd rather not install it, use the Docker one-liner below. |

Nothing is installed into your system PHP or MySQL — the entire environment is disposable.

The theme itself requires **PHP 7.4+** and **WordPress 6.3+** (it passes a `strategy` argument to `wp_enqueue_script`, added in 6.3), plus the free **Advanced Custom Fields** and **Contact Form 7** plugins. `wp-env` supplies all of this locally; for a real server see the [deployment guide](docs/deployment-guide.md).

---

## Setup

```bash
git clone <repository-url> holidays-website
cd holidays-website

# 1. Install the local WordPress environment tooling.
npm install

# 2. Install the theme's dev dependencies (PHPUnit + the WordPress test suite).
#    Required for running tests; not needed just to browse the site.
cd wp-content/themes/uttarakhand-tours && composer install && cd -

# 3. Boot WordPress.
npx wp-env start
```

**No Composer on your machine?** Docker is already a requirement, so use the official image instead of step 2:

```bash
docker run --rm -v "$PWD/wp-content/themes/uttarakhand-tours":/app composer:2 install
```

### First-run configuration

`wp-env` gives you a bare WordPress install, so two things need setting once:

```bash
# Activate the theme. This also seeds the region/theme terms, the About and
# Contact pages, and both Contact Form 7 forms (all idempotent — re-activating
# never duplicates them or discards your edits).
npx wp-env run cli wp theme activate uttarakhand-tours

# Enable pretty permalinks, so the package archive lives at /travel-packages/.
npx wp-env run cli wp rewrite structure '/%postname%/'
```

Advanced Custom Fields and Contact Form 7 are installed automatically by `.wp-env.json` — you don't need to add them.

---

## Running

| | URL | Credentials |
| --- | --- | --- |
| Site | http://localhost:8888 | — |
| Admin | http://localhost:8888/wp-admin | `admin` / `password` |
| Test site | http://localhost:8889 | (used by the test suite) |

```bash
npx wp-env start     # start (also applies .wp-env.json changes)
npx wp-env stop      # stop the containers
npx wp-env clean all # wipe the databases and start fresh
npx wp-env destroy   # remove the environment entirely

# Run any WP-CLI command
npx wp-env run cli wp <command>
```

`WP_DEBUG` is on, so PHP notices surface rather than failing silently.

---

## Tests

The suite boots the real WordPress core test suite and renders the actual templates, so it covers markup, queries, taxonomies, filtering, escaping, and the lead-capture forms.

```bash
npm run test:php
```

```bash
# One test class
npx wp-env run tests-cli --env-cwd=wp-content/themes/uttarakhand-tours \
  vendor/bin/phpunit --filter Test_Homepage

# One test by name
npx wp-env run tests-cli --env-cwd=wp-content/themes/uttarakhand-tours \
  vendor/bin/phpunit --filter test_hero_filter_bar_submits_to_the_archive
```

Narrow with `--filter`, not by passing a file path — the test filenames are
kebab-case while the classes are `Test_Homepage`-style, so PHPUnit cannot
resolve a class from a filename here.

Several tests assert on **exact** markup — the hero form's opening tag, single-class attributes like `class="package-card"`, and the absence of the word "price" anywhere on the Contact page. Run the suite after changing templates, not just after changing PHP logic.

---

## Project structure

```
wp-content/themes/uttarakhand-tours/
├── style.css                    Design tokens + the entire stylesheet (no build step)
├── functions.php                Theme supports, font + stylesheet loading
├── header.php / footer.php      Site chrome, skip link, <main> container
├── front-page.php               Homepage: hero, featured packages, regions, testimonials
├── archive-travel_package.php   Package listing + server-side region/theme filtering
├── single-travel_package.php    Package detail page
├── page-contact.php             Contact page (overrides page.php for the "contact" slug)
├── page.php / index.php         Editorial pages and the required fallback
├── inc/
│   ├── post-types.php           travel_package + testimonial CPTs
│   ├── taxonomies.php           package_region + package_theme
│   ├── acf-fields.php           Package field group, registered in PHP
│   ├── package-card.php         Shared card markup
│   ├── lead-capture-forms.php   The two Contact Form 7 forms, created in code
│   ├── whatsapp.php             Click-to-chat links + Customizer setting
│   ├── contact-page.php         Contact details Customizer settings + page seeding
│   ├── about-fleet-page.php     About page seeding
│   ├── route-map.php            Route Stops parsing + Leaflet map
│   ├── testimonials-gallery.php Testimonials + the aggregated sitewide gallery
│   ├── navigation.php           Menu locations + fallback menus
│   └── performance.php          WebP sub-sizes, asset trimming
└── tests/php/                   PHPUnit suite
```

There is **no build step**. `style.css` is served directly; edit it and reload.

---

## Theming

The entire visual system is defined as custom properties in the `:root` block at the top of `style.css`. Changing a token updates every component that uses it — there is no other place colours, spacing, or type sizes are hardcoded.

| Token group | Examples | Controls |
| --- | --- | --- |
| Palette | `--ut-forest-900`, `--ut-glacier`, `--ut-saffron` | Deep-forest ink, glacier surfaces, and the single saffron accent |
| Roles | `--ut-ground`, `--ut-ink`, `--ut-line` | Which palette value each semantic role points at |
| Type | `--ut-font-display`, `--ut-font-ui`, `--ut-step--2` … `--ut-step-5` | Fraunces/Manrope and a fluid `clamp()` scale |
| Space | `--ut-space-3xs` … `--ut-space-2xl`, `--ut-section` | Spacing rhythm and the gap between page sections |
| Layout | `--ut-content`, `--ut-measure`, `--ut-gutter` | Content column width (71rem), reading measure, page gutters |
| Shape and depth | `--ut-radius-s/m/l`, `--ut-shadow-1/2/3` | Corner radii and forest-tinted shadows |
| Motion | `--ut-ease`, `--ut-fast/mid/slow` | Transition timing |

There is deliberately **one** accent colour. Adding a second is the fastest way to make the design look generic.

`<main>` is a named-line grid: direct children sit in the content column by default, and `grid-column: full` opts an element into full-bleed (only the homepage hero uses it). That is why templates need no wrapper `<div>` per section.

### External requests

| Resource | Loaded from | Where |
| --- | --- | --- |
| Fraunces + Manrope | `fonts.googleapis.com` / `fonts.gstatic.com` | Every page, `display=swap` + preconnect |
| Leaflet 1.9.4 | `unpkg.com` | Single package pages only, and only when the package has route stops |

Both are third-party. To self-host, replace the URL in `uttarakhand_tours_enqueue_styles()` (`functions.php`) and in `uttarakhand_tours_enqueue_route_map_assets()` (`inc/route-map.php`).

### Performance and accessibility

Built for slow mountain connections, so the following are intentional and worth preserving:

- One stylesheet, no JavaScript framework, no build output. Leaflet is the only script, deferred and page-scoped.
- Contact Form 7's CSS/JS is restricted to the two page types that actually contain a form (`inc/performance.php`).
- Generated image sub-sizes are converted to WebP; card and gallery images set `loading` explicitly, because WordPress's automatic lazy-loading heuristic never sees images rendered from secondary queries.
- The hero's mountain artwork is inline SVG and CSS gradients — no image request.
- Skip link, landmark elements, visible focus rings, `aria-current` on the active nav item, and labelled gallery links. `prefers-reduced-motion` disables every transform and transition.

Colour pairings meet WCAG AA. If you change the palette, re-check contrast — saffron on white does not pass at normal text sizes, which is why `--ut-saffron-deep` exists for accent *text*.

### Conventions

WordPress coding standards: tabs, `snake_case`, every function prefixed `uttarakhand_tours_`. Escape on output (`esc_html`, `esc_url`, `esc_attr`, `wp_kses_post`) and sanitize on input. No linter is configured, so match the surrounding style.

The `uttarakhand-tours` text domain is used throughout, but `load_theme_textdomain()` is not called and there is no `languages/` directory — the strings are wrapped and ready for translation, but no translation is loaded yet.

---

## Managing content from wp-admin

Everything below is editable without touching code. For step-by-step walkthroughs of the most common jobs, see [docs/client-guide.md](docs/client-guide.md).

### Travel packages

**Travel Packages → Add New.** The title, the overview in the main editor, and the **Featured Image** drive every listing. The **Travel Package Details** box below holds price, duration, pickup/drop, vehicle options, driver-allowance and toll toggles, hotel tier, meal plan, itinerary, inclusions, exclusions, route stops, and the Mountain Advisory.

Assign **Package Regions** and **Package Themes** in the sidebar — these power the homepage and archive filters. Manage the terms themselves under **Travel Packages → Regions / Themes**.

**Route Stops** takes one stop per line as `Place Name | latitude, longitude`. Malformed lines are skipped rather than breaking the map; leave the field empty and no map renders.

**Mountain Advisory** is written by you and is only as current as your last edit — it is not a live weather or traffic feed. Leave it empty and the callout does not appear.

### Photos

Add a **Gallery** block to a package's main content. Those photos appear on the package page *and* feed the homepage's "From our trips" gallery automatically — you never upload the same photo twice. Clicking any photo in either gallery opens the photo itself.

### Testimonials

**Testimonials → Add New.** Reviewer's name as the title, their quote as the content, their photo as the featured image. They render as a masonry wall on the homepage. No testimonials, no section.

### Pages

- **About Us & Fleet/Hotels** — a normal page, fully editable in the block editor.
- **Contact** — renders your Customizer contact details, the WhatsApp link, and the Custom Package Request form. Note that text typed into this page's editor is **not** displayed.

### Site-wide settings

| Setting | Where |
| --- | --- |
| Site name and tagline (both appear in the header) | **Settings → General** |
| Logo (replaces the site name when set) | **Appearance → Customize → Site Identity** |
| WhatsApp number — powers every click-to-chat link | **Appearance → Customize → WhatsApp** |
| Phone, email, address — shown on Contact *and* in the footer | **Appearance → Customize → Contact Details** |
| Header and footer navigation | **Appearance → Menus** → assign to "Primary Menu" / "Footer Menu" |
| The two inquiry forms | **Contact → Contact Forms** |

Leave the WhatsApp number blank and every WhatsApp button disappears rather than linking nowhere. Until you build a menu, the header falls back to an automatic list of Packages / About us / Contact.

### What is *not* editable from wp-admin

This copy lives in the template files and needs a developer to change:

- The homepage hero headline and the sentence beneath it (`front-page.php`)
- The four "Why travel with us" badges (`front-page.php`, `$trust_badges`)
- Section headings across the homepage and package pages
- The packages-archive intro and its "no packages match" text (`archive-travel_package.php`)
- The note above the package inquiry form (`single-travel_package.php`)
- The footer description and the closing line about nothing being reserved (`footer.php`)

If any of this needs to change regularly, it should move into Customizer settings alongside the WhatsApp and contact-details fields.

---

## Deploying

See **[docs/deployment-guide.md](docs/deployment-guide.md)** for going live on a real domain: server requirements, what to upload and what to leave behind, first-activation steps, and the email configuration that inquiries depend on.

One thing worth knowing before you start: both forms send from `wordpress@yourdomain.com` by default, which most mail providers reject or spam-filter. **Configure SMTP before launch, or inquiries silently never arrive** — and inquiries are the entire point of this site. The guide covers it.

---

## Troubleshooting

**`npx wp-env start` fails** — check Docker is actually running. On a port clash, create `.wp-env-override.json` (already gitignored):

```json
{ "port": 9888, "testsPort": 9889 }
```

**`/travel-packages/` returns 404** — permalinks are unset or rewrite rules are stale:

```bash
npx wp-env run cli wp rewrite structure '/%postname%/'
npx wp-env run cli wp rewrite flush --hard
```

**Package fields are missing in the admin** — Advanced Custom Fields isn't active. `npx wp-env run cli wp plugin list` should show `advanced-custom-fields` and `contact-form-7` as active.

**No inquiry form on package pages** — the Contact Form 7 forms are created on theme activation. Re-activate to seed them:

```bash
npx wp-env run cli wp theme activate twentytwentyfour
npx wp-env run cli wp theme activate uttarakhand-tours
```

**Tests fail with "Class ... could not be found"** — you passed a file path. Use `--filter ClassName` instead.

**`vendor/bin/phpunit: not found`** — Composer dependencies aren't installed. See Setup step 2.

**Environment is in a bad state** — `npx wp-env clean all` resets the databases; `npx wp-env destroy` removes it entirely and lets you start over.

---

## License

GPL-2.0-or-later, matching WordPress itself. Fraunces and Manrope are licensed under the SIL Open Font License; Leaflet is BSD-2-Clause.

---

## Further reading

| Document | Contents |
| --- | --- |
| [CONTEXT.md](CONTEXT.md) | Domain vocabulary — the words this project uses and the ones it avoids |
| [docs/client-guide.md](docs/client-guide.md) | Task-by-task guide for the site owner |
| [docs/deployment-guide.md](docs/deployment-guide.md) | Taking the site live on a real domain |
| [docs/adr/](docs/adr/) | Architecture decisions and their reasoning |
| [AGENTS.md](AGENTS.md) | Issue tracker, triage labels, and domain-doc conventions |
