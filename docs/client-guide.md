# Managing Your Website

This guide covers the day-to-day tasks you'll use most often: adding a new travel package, managing its photos, updating your WhatsApp number, adding regions/themes, and updating road/weather advisories. Everything here is done from your WordPress admin dashboard (usually at `yoursite.com/wp-admin`) — no coding required.

## Adding a New Travel Package

1. In the left-hand admin menu, click **Travel Packages → Add New**.
2. Enter the package's name as the **Title** (e.g. "Kedarnath Yatra Package") and write a short overview in the main content area below it.
3. Set a **Featured Image** in the box on the right — this is the main photo shown on package listings and at the top of the package's page.
4. Scroll down to the **Travel Package Details** box and fill in as many fields as apply:
   - **Price (Starting From)** — a plain starting price, no calculations needed
   - **Duration** — e.g. "5 Days / 4 Nights"
   - **Pickup / Drop Location**
   - **Vehicle Options** — tick all that apply (Sedan, SUV/Innova, Tempo Traveller)
   - **Driver Allowance Included** / **Toll & Parking Included** — toggle on or off
   - **Hotel Tier** — Standard, Deluxe, or Luxury
   - **Meal Plan** — EP, CP, or MAP
   - **Itinerary**, **Inclusions**, **Exclusions** — write these like normal formatted text (you can use bold, bullet lists, etc.)
   - **Route Stops** — one stop per line, in the format `Place Name | latitude, longitude` (e.g. `Guptkashi | 30.531, 79.081`). This draws the route map on the package's page. If you're not sure of a place's coordinates, search for it on Google Maps, right-click the pin, and the coordinates are the first thing shown.
   - **Mountain Advisory** — see the dedicated section below.
5. On the right-hand side, under **Package Regions**, tick the region(s) this package belongs to (e.g. Garhwal). Under **Package Themes**, start typing the theme name (e.g. Pilgrimage) and select it from the suggestions — you can add more than one. If the region or theme you need doesn't exist yet, see "Adding a New Region or Theme" below.
6. When you're happy with everything, click **Publish** (or **Update** if you're editing an existing package).

Your new package will now appear on the packages archive page and can be filtered by its region/theme.

## Managing a Package's Photos (Gallery)

Each package can have its own photo gallery, which also feeds the "From Our Trips" gallery on the homepage automatically — you only need to upload photos once.

1. While editing a Travel Package, click into the main content area (below the title).
2. Click the **Add Media** button (or, in the block editor, add a **Gallery** block) and select or upload the photos for this package.
3. Save/Publish the package.

That's it — the homepage's sitewide gallery automatically pulls in photos from every published package's gallery. You don't need to upload the same photos again anywhere else.

## Updating Your WhatsApp Number

Your WhatsApp number powers the floating "Chat on WhatsApp" button that appears on every package page, as well as the "Inquire About This Package" button and the Contact page's WhatsApp link.

1. In the admin menu, go to **Appearance → Customize**.
2. Click into the **WhatsApp** section.
3. Update the **WhatsApp Number** field (e.g. `+91 98765 43210`).
4. Click **Publish** to save.

The new number takes effect immediately, everywhere the WhatsApp button appears — you don't need to update it in more than one place.

## Adding a New Region or Theme

Regions (e.g. Garhwal, Kumaon) and Themes (e.g. Trekking, Honeymoon) are the tags used to organize and filter your packages.

1. In the admin menu, go to **Travel Packages → Regions** (for a region) or **Travel Packages → Themes** (for a theme).
2. Fill in the **Name** field with the new region or theme (e.g. "Panch Kedar").
3. Click **Add New Package Region** (or **Add New Package Theme**).

The new term is now available to select the next time you add or edit a package, and it automatically appears in the homepage's region filter and "Popular Regions" links.

## Updating Mountain Advisory Content

The Mountain Advisory is the callout on a package's page covering things like road closures, monsoon conditions, permit requirements, and recommended gear. It's written and updated by you — it doesn't pull from any live weather or traffic feed, so it's only as current as your last update.

1. Open the relevant package under **Travel Packages**.
2. Scroll to the **Travel Package Details** box and find the **Mountain Advisory** field.
3. Update the text as needed (you can use bold, bullet lists, etc., the same as the Itinerary field).
4. Click **Update** to save.

If a package has no advisory content, that section simply won't appear on its page — you don't need to leave a placeholder.
