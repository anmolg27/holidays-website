<?php
/**
 * Site-wide primary navigation. No template ever built one before this
 * design pass — header.php had no nav markup at all, leaving no way to
 * reach the About or Contact pages except through in-content links. This
 * registers the nav menu location and seeds a default menu (Home, Packages,
 * About Us & Fleet/Hotels, Contact), idempotent like the taxonomy terms and
 * seeded pages, so navigation exists without the client configuring it.
 */

function uttarakhand_tours_register_nav_menu() {
	register_nav_menu( 'primary', __( 'Primary Navigation', 'uttarakhand-tours' ) );
}
add_action( 'after_setup_theme', 'uttarakhand_tours_register_nav_menu' );

/**
 * Creates a default "Primary Navigation" menu on theme activation and
 * assigns it to the `primary` location. Skips creation if a menu already
 * assigned there actually has items, so re-activating the theme never
 * overwrites a client's own menu edits. The item count check (rather than
 * just has_nav_menu()) guards against an edge case seen in this theme's own
 * test bootstrap: a menu created but left with zero items (e.g. by a run
 * that hit an error mid-creation) would otherwise block every future
 * attempt to populate it.
 */
function uttarakhand_tours_seed_primary_nav_menu() {
	$existing_menu = null;

	if ( has_nav_menu( 'primary' ) ) {
		$locations     = get_nav_menu_locations();
		$existing_menu = wp_get_nav_menu_object( $locations['primary'] );

		if ( $existing_menu && $existing_menu->count > 0 ) {
			return;
		}
	}

	// Reuse the existing (empty) menu term rather than creating a new one —
	// wp_create_nav_menu() would fail on the duplicate "Primary Navigation"
	// name otherwise.
	$menu_id = $existing_menu ? $existing_menu->term_id : wp_create_nav_menu( 'Primary Navigation' );

	if ( is_wp_error( $menu_id ) ) {
		return;
	}

	wp_update_nav_menu_item(
		$menu_id,
		0,
		array(
			'menu-item-title'  => 'Home',
			'menu-item-url'    => home_url( '/' ),
			'menu-item-status' => 'publish',
			'menu-item-type'   => 'custom',
		)
	);

	$archive_link = get_post_type_archive_link( 'travel_package' );

	if ( $archive_link ) {
		wp_update_nav_menu_item(
			$menu_id,
			0,
			array(
				'menu-item-title'  => 'Packages',
				'menu-item-url'    => $archive_link,
				'menu-item-status' => 'publish',
				'menu-item-type'   => 'custom',
			)
		);
	}

	$about_page = get_page_by_path( UTTARAKHAND_TOURS_ABOUT_FLEET_PAGE_SLUG );

	if ( $about_page ) {
		wp_update_nav_menu_item(
			$menu_id,
			0,
			array(
				'menu-item-title'  => 'About Us',
				'menu-item-object' => 'page',
				'menu-item-object-id' => $about_page->ID,
				'menu-item-type'   => 'post_type',
				'menu-item-status' => 'publish',
			)
		);
	}

	$contact_page = get_page_by_path( UTTARAKHAND_TOURS_CONTACT_PAGE_SLUG );

	if ( $contact_page ) {
		wp_update_nav_menu_item(
			$menu_id,
			0,
			array(
				'menu-item-title'  => 'Contact',
				'menu-item-object' => 'page',
				'menu-item-object-id' => $contact_page->ID,
				'menu-item-type'   => 'post_type',
				'menu-item-status' => 'publish',
			)
		);
	}

	$locations              = get_theme_mod( 'nav_menu_locations', array() );
	$locations['primary']   = $menu_id;
	set_theme_mod( 'nav_menu_locations', $locations );
}
/*
 * Hooked to `init` (guarded by has_nav_menu(), so it's a no-op on every
 * request after the first) rather than `after_switch_theme`: nav menu
 * items are `nav_menu_item` posts, and that post type — like every other
 * core post type and taxonomy — isn't registered yet when
 * `after_switch_theme` fires. Creating the menu term there silently
 * succeeds (taxonomies are looser about this) while every item insert
 * silently fails, leaving a permanently empty menu.
 */
add_action( 'init', 'uttarakhand_tours_seed_primary_nav_menu', 20 );

/**
 * Renders the primary nav menu, or an empty string when no menu is
 * assigned to the `primary` location — callers can skip the section
 * entirely rather than rendering an empty shell.
 */
function uttarakhand_tours_render_primary_nav() {
	if ( ! has_nav_menu( 'primary' ) ) {
		return '';
	}

	return wp_nav_menu(
		array(
			'theme_location' => 'primary',
			'container'      => 'nav',
			'container_class' => 'primary-nav',
			'container_aria_label' => 'Primary',
			'menu_class'     => 'primary-nav-list',
			'fallback_cb'    => false,
			'echo'           => false,
		)
	);
}
