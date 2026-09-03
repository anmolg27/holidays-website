<?php
/**
 * About Us & Fleet/Hotels page: a standard WordPress Page (rendered by
 * page.php) seeded in code — like the taxonomy terms and lead-capture
 * forms — so it exists on every environment without manual re-creation.
 * Purely editorial content; the client edits it via the block editor from
 * here on.
 */

const UTTARAKHAND_TOURS_ABOUT_FLEET_PAGE_SLUG = 'about-us-fleet-hotels';

/**
 * Creates the "About Us & Fleet/Hotels" page on theme activation. Idempotent:
 * skips creation if a page with the same slug already exists, so
 * re-activating the theme never duplicates the page or discards edits a
 * client has made to it.
 */
function uttarakhand_tours_seed_about_fleet_page() {
	if ( get_page_by_path( UTTARAKHAND_TOURS_ABOUT_FLEET_PAGE_SLUG ) ) {
		return;
	}

	wp_insert_post(
		array(
			'post_type'    => 'page',
			'post_status'  => 'publish',
			'post_title'   => 'About Us & Fleet/Hotels',
			'post_name'    => UTTARAKHAND_TOURS_ABOUT_FLEET_PAGE_SLUG,
			'post_content' => uttarakhand_tours_about_fleet_page_content(),
		)
	);
}
add_action( 'after_switch_theme', 'uttarakhand_tours_seed_about_fleet_page' );

/**
 * Starter editorial content covering company background, driver expertise,
 * fleet options, and partnered stays, as ordinary block-editor blocks the
 * client can freely edit afterwards.
 */
function uttarakhand_tours_about_fleet_page_content() {
	return implode(
		"\n\n",
		array(
			"<!-- wp:heading -->\n<h2>Our Story</h2>\n<!-- /wp:heading -->",
			"<!-- wp:paragraph -->\n<p>We're a local team driving travelers through the mountains, valleys, and pilgrimage routes of Garhwal and Kumaon, combining reliable cab transportation, comfortable stays, and local knowledge into one dependable trip. (Edit this section with your company's own background.)</p>\n<!-- /wp:paragraph -->",
			"<!-- wp:heading -->\n<h2>Driver Expertise</h2>\n<!-- /wp:heading -->",
			"<!-- wp:paragraph -->\n<p>Our drivers are experienced mountain-road specialists, familiar with hairpin bends, monsoon conditions, and high-altitude routes across Uttarakhand — trained to keep every journey safe and unhurried.</p>\n<!-- /wp:paragraph -->",
			"<!-- wp:heading -->\n<h2>Our Fleet</h2>\n<!-- /wp:heading -->",
			"<!-- wp:paragraph -->\n<p>We maintain a range of well-serviced vehicles — sedans, SUVs/Innovas, and tempo travellers — to suit groups of any size, all sanitized and inspected before every trip.</p>\n<!-- /wp:paragraph -->",
			"<!-- wp:heading -->\n<h2>Partnered Stays</h2>\n<!-- /wp:heading -->",
			"<!-- wp:paragraph -->\n<p>We work with a trusted network of hotels and homestays across the region, spanning standard, deluxe, and luxury tiers, so accommodation is arranged as part of one seamless package.</p>\n<!-- /wp:paragraph -->",
		)
	);
}
