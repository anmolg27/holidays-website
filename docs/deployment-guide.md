# Deployment Guide

How to take Uttarakhand Tours live on a real domain, and how to push changes afterwards.

This assumes ordinary WordPress hosting — shared hosting with cPanel, a managed WordPress host, or your own VPS. The theme has no build step and no Node/Composer requirement in production, so any host that runs WordPress will run this site.

> **Read this first.** Both inquiry forms send email from `wordpress@yourdomain.com`, an address that does not exist. Most mail providers reject or spam-filter it. If you skip the [Email deliverability](#5-email-deliverability-do-not-skip-this) step, the site will look like it is working while every lead silently vanishes. Leads are the only thing this site produces.

---

## Server requirements

| | Minimum | Recommended |
| --- | --- | --- |
| PHP | 7.4 | 8.1–8.3 |
| WordPress | 6.3 | Latest |
| MySQL / MariaDB | 5.7 / 10.4 | 8.0 / 10.6 |
| PHP extensions | GD or Imagick **with WebP support** | Imagick |
| HTTPS | Required | — |

Why each of these is here:

- **PHP 7.4** is the theme's floor; 8.1+ is materially faster.
- **WordPress 6.3** is required because `inc/route-map.php` passes a `strategy` argument to `wp_enqueue_script()`, which was added in 6.3.
- **WebP** matters because `inc/performance.php` converts generated image sub-sizes to WebP. Without it the site still works — images just stay JPEG/PNG and weigh more, which is exactly the wrong trade on the connections this site targets.
- **MySQL/MariaDB** is WordPress's own floor; the theme adds no requirement.

Required plugins, both free from the WordPress.org directory:

- **Advanced Custom Fields** — the package detail fields. Without it, packages lose price, duration, itinerary, route, and advisory.
- **Contact Form 7** — both lead-capture forms.

### Verifying all of this from wp-admin

Nearly everything is on one screen: **Tools → Site Health → Info** (`/wp-admin/site-health.php?tab=debug`). Expand the panels below.

| Requirement | Panel | Field |
| --- | --- | --- |
| PHP version | **Server** | `PHP version` |
| WordPress version | **WordPress** | `Version` — also in the bottom-right of any admin page |
| Database version | **Database** | `Server version` |
| WebP support | **Media Handling** | `Active editor`, then `ImageMagick supported file formats` or `GD supported file formats` — look for **WEBP** |
| HTTPS | **WordPress** | `Is this site using HTTPS?` |
| Required plugins | **Active Plugins** | Advanced Custom Fields and Contact Form 7 both listed |

Check the **Status** tab (`/wp-admin/site-health.php`) too — it proactively flags outdated PHP, missing PHP modules, and a broken REST API, so it usually names the problem before you go looking for it.

The Info tab's **"Copy site info to clipboard"** button dumps the whole report as text, which is the fastest way to hand it to your host or a developer.

Falling short? PHP version and image libraries are host-level settings, not WordPress ones — on cPanel look for **Select PHP Version** or **MultiPHP Manager**, otherwise ask the host. WordPress itself updates from **Dashboard → Updates**.

---

## 1. Upload the theme

The theme is the only thing this repository deploys. It goes in `wp-content/themes/uttarakhand-tours/` on the server.

**Do not upload these** — they are development-only and `vendor/` in particular contains the full PHPUnit toolchain plus duplicate copies of ACF and Contact Form 7, which is both dead weight and an unnecessary attack surface:

```
vendor/
tests/
composer.json
composer.lock
phpunit.xml.dist
.phpunit.result.cache
```

Nothing in the theme's runtime loads `vendor/autoload.php`, so leaving it out is safe.

### Option A — Git on the server (recommended)

```bash
cd /path/to/wordpress/wp-content/themes
git clone <repository-url> uttarakhand-tours-repo
ln -s uttarakhand-tours-repo/wp-content/themes/uttarakhand-tours uttarakhand-tours
```

Updating later is `git pull`. Because `vendor/` is gitignored, the excluded files never reach the server in the first place.

If your host disallows symlinks, clone outside the web root and copy the theme directory in.

### Option B — rsync

```bash
rsync -avz --delete \
  --exclude='vendor/' \
  --exclude='tests/' \
  --exclude='composer.*' \
  --exclude='phpunit.xml.dist' \
  --exclude='.phpunit.result.cache' \
  wp-content/themes/uttarakhand-tours/ \
  user@yourhost:/path/to/wordpress/wp-content/themes/uttarakhand-tours/
```

> `--delete` removes server files absent from your copy. Run once with `--dry-run` first.

### Option C — zip upload (simplest, works on every host)

Build the zip from the project root:

```bash
npm run build:theme
```

That produces `uttarakhand-tours.zip` (~40 KB) in the project root, with `vendor/`, `tests/`, and the Composer/PHPUnit files stripped out. It overwrites any previous build, so run it again after every change — `zip` appends to an existing archive rather than replacing it, which is why the script deletes the old file first.

Then upload via **Appearance → Themes → Add New → Upload Theme → Activate**.

The archive is gitignored — it is a build artifact, not source.

<details>
<summary>Doing it by hand instead</summary>

The zip must contain **one top-level folder** named `uttarakhand-tours`, with `style.css` directly inside it. WordPress rejects the upload otherwise.

Do **not** right-click the theme folder and compress it as-is: that ships `vendor/` (the entire PHPUnit toolchain plus duplicate copies of ACF and Contact Form 7) and `tests/` to your public server. Copy the folder first, delete the excluded paths listed above from the copy, then compress the copy.

The equivalent command is:

```bash
cd wp-content/themes
zip -rq ../../uttarakhand-tours.zip uttarakhand-tours \
  -x 'uttarakhand-tours/vendor/*' \
     'uttarakhand-tours/tests/*' \
     'uttarakhand-tours/composer.*' \
     'uttarakhand-tours/phpunit.xml.dist' \
     'uttarakhand-tours/.phpunit.result.cache' \
     '*/.DS_Store'
```

</details>

When re-uploading an updated theme, WordPress asks to replace the existing one. That is fine — but bump `Version:` in `style.css` first, or returning visitors keep the cached old stylesheet (see step 10).

---

## 2. Activate

Install and activate Advanced Custom Fields and Contact Form 7 **before** the theme, then activate Uttarakhand Tours under **Appearance → Themes**.

Activation seeds, once:

- Region terms — Garhwal, Kumaon, Char Dham, Border circuits
- Theme terms — Pilgrimage, Trekking, Honeymoon, Family, Weekend
- The **About Us & Fleet/Hotels** page, with starter copy
- The **Contact** page
- Both Contact Form 7 forms

Every seed is idempotent: it skips anything that already exists, so re-activating never duplicates content or overwrites edits.

If Contact Form 7 was activated *after* the theme, the forms will be missing. Switch to another theme and back to seed them.

---

## 3. Permalinks

The package archive lives at `/travel-packages/`, which requires pretty permalinks.

**Settings → Permalinks → Post name → Save Changes.** Saving flushes the rewrite rules, which is what actually registers the custom post type's URLs. Do this even if the setting already looks correct — a fresh install often needs the flush.

Verify `https://yourdomain.com/travel-packages/` loads rather than 404s.

---

## 4. Configure the site

| Setting | Where | Notes |
| --- | --- | --- |
| Site title and tagline | **Settings → General** | Both appear in the header |
| Logo | **Appearance → Customize → Site Identity** | Optional; replaces the site name |
| WhatsApp number | **Appearance → Customize → WhatsApp** | e.g. `+91 98765 43210`. Blank hides every WhatsApp button |
| Phone, email, address | **Appearance → Customize → Contact Details** | Shown on Contact *and* in the footer |
| Navigation | **Appearance → Menus** | Assign to "Primary Menu" and "Footer Menu" |
| Admin email | **Settings → General** | **Every inquiry goes here** — make sure it is a monitored inbox |
| Timezone | **Settings → General** | Set to Kolkata so submission timestamps read correctly |
| Search engine visibility | **Settings → Reading** | Ensure "Discourage search engines" is **unticked** |

That last one is the single most common launch mistake: it stays ticked from staging and quietly deindexes the site.

---

## 5. Email deliverability (do not skip this)

Both forms are configured to send **to** the WordPress admin email and **from** `[_site_title] <wordpress@yourdomain.com>`.

That from-address is a problem. If your domain publishes SPF or DMARC records — most do — mail claiming to come from your domain but sent by a random web server fails authentication and is rejected or junked. PHP's `mail()` is also disabled outright on many hosts. Either way, forms appear to submit successfully and nothing arrives.

**Fix before launch:**

1. Install an SMTP plugin (WP Mail SMTP, FluentSMTP, or Post SMTP).
2. Connect a real sending service — your host's authenticated SMTP, Google Workspace, Brevo, Mailgun, SES.
3. Set the from-address to a real mailbox on your domain, e.g. `trips@yourdomain.com`, and align SPF/DKIM as the provider instructs.
4. Update both forms under **Contact → Contact Forms → Mail**, replacing the `wordpress@[_site_url]` sender.

**Then test properly:** submit the inquiry form on a live package page *and* the Custom Package Request form on the Contact page, and confirm both arrive in the real inbox — not just that the success message appears. Check the spam folder too.

### Install Flamingo as a backstop

**Contact Form 7 stores nothing.** No database table, no admin screen. The email *is* the record, so a message that bounces, lands in spam, or hits a misconfigured mail server is gone permanently.

[Flamingo](https://wordpress.org/plugins/flamingo/) is free, by the same author as Contact Form 7, and needs no configuration: **Plugins → Add New → Flamingo → Install → Activate.** Submissions then appear under **Flamingo → Inbound Messages**, with contacts collected in **Address Book**.

Crucially, it captures submissions *even when mail fails*. From Contact Form 7's own `modules/flamingo.php`:

```php
$cases = (array) apply_filters( 'wpcf7_flamingo_submit_if',
	array( 'spam', 'mail_sent', 'mail_failed' )
);
```

So install it **before** troubleshooting SMTP, not after — every inquiry that arrives while mail is broken is still captured.

Two caveats: it is not retroactive, so anything submitted before activation is unrecoverable; and its Address Book keys on email, which the seeded forms leave optional. A traveller who leaves only a phone number still produces a complete Inbound Message, they just may not appear as a named contact.

---

## 6. HTTPS

Install a certificate (most hosts offer free Let's Encrypt), then set both **WordPress Address** and **Site Address** under **Settings → General** to `https://`.

The theme loads fonts and Leaflet over HTTPS already, so there is nothing to fix for mixed content in the theme. If content editors paste `http://` image URLs, run a search-replace:

```bash
wp search-replace 'http://yourdomain.com' 'https://yourdomain.com' --skip-columns=guid --dry-run
```

Drop `--dry-run` once the reported counts look right.

---

## 7. Add real content

The site ships with structure but no packages. Working order:

1. **Travel Packages → Add New** for each trip — title, overview, featured image, gallery, and the Travel Package Details fields. See [client-guide.md](client-guide.md).
2. **Testimonials** — name, photo, quote. Omitted from the homepage entirely if there are none.
3. Edit the **About Us & Fleet/Hotels** page; the seeded copy is a placeholder that says so.
4. Adjust region and theme terms to match what you actually sell.

Some homepage and footer copy lives in the template files rather than the admin — the hero headline, the four trust badges, section headings, the footer description. See "What is *not* editable from wp-admin" in the [README](../README.md). Review that wording before launch, because changing it later needs a developer.

---

## 8. Pre-launch checklist

- [ ] `/travel-packages/` loads and filtering by region and theme works
- [ ] A package page shows price, itinerary, inclusions, route map, and advisory
- [ ] **Both forms deliver to a real monitored inbox** (verified by actual submission)
- [ ] Both forms ask for the visitor's name and phone — a lead you cannot contact is not a lead
- [ ] Flamingo is active and the test submission appears under Inbound Messages
- [ ] WhatsApp buttons open a chat with the correct number
- [ ] Header and footer menus are assigned
- [ ] "Discourage search engines" is unticked
- [ ] HTTPS everywhere, no mixed-content warnings
- [ ] Checked on a real phone, not just a narrow browser window
- [ ] Automated backups are running
- [ ] Admin password is strong and the default `admin` username is not in use

---

## 9. Ongoing maintenance

**Backups.** Files and database, automated, stored off-server. Verify a restore works before you need it.

**Updates.** Keep WordPress, ACF, and Contact Form 7 current — Contact Form 7 especially, as a public form endpoint. Test on staging first where you can.

**Security basics.** Add to `wp-config.php`:

```php
define( 'DISALLOW_FILE_EDIT', true );  // no theme/plugin editing from wp-admin
define( 'WP_DEBUG', false );           // never expose PHP notices in production
```

`.wp-env.json` sets `WP_DEBUG` to true for local development; production must not inherit that.

**Caching.** A page-cache plugin or host-level caching helps considerably on slow connections. Two rules: exclude the Contact page and single package pages from caching if you cache aggressively, so form nonces stay valid; and clear the cache after publishing a package, or the archive will keep serving the old list.

---

## 10. Deploying changes later

For theme updates:

1. Test locally — `npm run test:php` must pass.
2. Pull or rsync to the server as in step 1.
3. Bump `Version:` in `style.css`. The stylesheet is enqueued with that version as a cache-buster, so **a CSS change without a version bump will not reach returning visitors.**
4. Clear any page cache.
5. Reload the live site and confirm the change.

Uploading a zip over an existing install shows a comparison table — *Current* vs *Uploaded*, with both version numbers. Choose **Replace current with uploaded**. The theme stays active; you do not re-activate it.

### What a theme update does not do

`after_switch_theme` does **not** fire on an update, so nothing is re-seeded. Pages, taxonomy terms, Customizer settings and Contact Form 7 forms are all left exactly as they are. That is usually what you want — it is why an update can never duplicate content or trample a client's edits.

The consequence catches people out: **changing a seeded form's template in code does not change the form on a live site.** The form already exists, and even a full re-activation skips it by design. To bring an existing site in line with an updated template:

1. Deploy the new theme version first
2. **Contact → Contact Forms** — delete the affected forms
3. Switch to any other theme, then back to Uttarakhand Tours

The forms are recreated from the current template. Every other seeder skips what already exists, so nothing duplicates. Do this before configuring SMTP and editing the mail From addresses, since re-seeding resets those to the default.

### After every deploy

- **Purge the page cache.** LiteSpeed Cache (preinstalled on many hosts) will otherwise serve the old stylesheet: **LiteSpeed Cache → Toolbox → Purge All.**
- **Verify the version actually landed:**

  ```bash
  curl -s https://yourdomain.com/ | grep -o 'style.css?ver=[0-9.]*'
  ```

  If that still reports the old number, the upload or the cache purge did not take.

If you add a custom post type, taxonomy, or rewrite rule, visit **Settings → Permalinks** and save once afterwards to flush rewrite rules.

---

## Appendix: Hostinger

Notes specific to Hostinger's hPanel, where this site is deployed.

### Where things live

| Task | hPanel path |
| --- | --- |
| PHP version | Websites → Dashboard → **Advanced → PHP Configuration** |
| SSH access | Websites → Dashboard → **Advanced → SSH Access** — [Premium Web plans and above](https://www.hostinger.com/support/1583645-how-to-enable-ssh-access-in-hostinger/); off by default |
| Git deployment | Websites → Dashboard → **Advanced → Git** |
| File Manager | Files → **File Manager** |
| Mailboxes | **Emails** |
| SSL | Websites → Dashboard → **Security → SSL** |
| Extra sites | Websites → **+ Add Website** |

### Use the zip upload, not Git

Hostinger's [Git auto-deploy](https://www.hostinger.com/support/1583302-how-to-deploy-a-git-repository-in-hostinger/) pulls a whole repository into one target directory. **This repository's root is not the theme root** — the theme lives at `wp-content/themes/uttarakhand-tours/`. Pointing Git deploy at the theme directory would drop `package.json`, `docs/` and a nested `wp-content/` tree inside it.

The theme is 40 KB with no build step, so `npm run build:theme` plus **Appearance → Themes → Upload Theme** takes under a minute. If push-to-deploy becomes worthwhile later, the clean route is a separate repository containing only the theme.

### SMTP

Hostinger includes email, which makes step 5 straightforward. Create a mailbox under **Emails**, then point an SMTP plugin at it:

| Field | Value |
| --- | --- |
| Host | `smtp.hostinger.com` |
| Port | `587` (TLS, preferred) or `465` (SSL) |
| Encryption | Match the port |
| Authentication | On |
| Username | the full email address |
| Password | that mailbox's password |

Hostinger's own guide: [WordPress SMTP setup](https://www.hostinger.com/tutorials/wordpress-smtp/).

### Two gotchas on a fresh install

- **"Coming soon" mode.** New sites ship with a placeholder enabled via the Hostinger Tools plugin. If the front end shows a holding page instead of the homepage, turn it off there.
- **LiteSpeed Cache is preinstalled.** Keep it, but purge after every theme deploy and after publishing a package, or the archive keeps serving the old list.

---

## Troubleshooting

**Everything 404s except the homepage** — flush permalinks (step 3).

**Package fields are missing** — Advanced Custom Fields is inactive or was removed. Field *values* survive in the database; reactivating restores them.

**No inquiry form on package pages** — Contact Form 7 is inactive, or the forms were never seeded. Check **Contact → Contact Forms** for "Package Inquiry" and "Custom Package Request"; re-activate the theme if absent.

**Forms submit but no email arrives** — see step 5. This is almost always SMTP.

**"There was an error trying to send your message"** — Contact Form 7's `mail_failed`: `wp_mail()` returned false, so PHP `mail()` is disabled or blocked on the host. Nothing was sent and, without Flamingo, nothing was stored. Configure SMTP (step 5). Use the SMTP plugin's own test tool first, since it reports the real error rather than Contact Form 7's generic message.

**A form is missing fields that the theme template has** — the form was created from an older version of the template and updates never overwrite existing forms. Either add the fields by hand in the form editor, or delete and re-seed (step 10).

**The route map is blank** — the package has no Route Stops, or the lines are malformed. The format is `Place Name | latitude, longitude`, one stop per line; invalid lines are skipped. The map also needs outbound access to `unpkg.com`.

**Fonts look wrong** — the site is falling back to Palatino/system fonts because `fonts.googleapis.com` is unreachable. Text remains fully readable by design; to remove the dependency, self-host the fonts (see Theming in the README).

**Homepage gallery is empty** — it aggregates gallery images from published packages. Add a Gallery block to a package's content; the homepage picks it up automatically.

**Site looks unstyled after an update** — the stylesheet version wasn't bumped, or a cache is serving the old file. Bump `Version:` in `style.css` and clear the cache.
