<?php
/**
 * Site navigation.
 *
 * The theme registers a Primary and a Footer menu location, but ships
 * fallbacks so a freshly activated site has working navigation before the
 * client has built a menu in wp-admin. The fallbacks link only to
 * destinations that actually exist (the Travel Package archive and the two
 * seeded pages), so no navigation item is ever a dead link.
 */

/**
 * Returns the permalink for a seeded page, or an empty string if that page
 * has been deleted — callers skip the item rather than linking nowhere.
 */
function uttarakhand_tours_get_page_url( $slug ) {
	$page = get_page_by_path( $slug );

	return $page ? get_permalink( $page ) : '';
}

/**
 * The navigation destinations, as an ordered slug => label map of links
 * that resolve. Shared by both fallback menus so the header and footer
 * never drift apart.
 */
function uttarakhand_tours_default_menu_items() {
	$items = array();

	$archive_url = get_post_type_archive_link( 'travel_package' );
	if ( $archive_url ) {
		$items[] = array(
			'url'     => $archive_url,
			'label'   => __( 'Travel Packages', 'uttarakhand-tours' ),
			'current' => is_post_type_archive( 'travel_package' ) || is_singular( 'travel_package' ),
		);
	}

	$about_url = uttarakhand_tours_get_page_url( UTTARAKHAND_TOURS_ABOUT_FLEET_PAGE_SLUG );
	if ( $about_url ) {
		$items[] = array(
			'url'     => $about_url,
			'label'   => __( 'About us', 'uttarakhand-tours' ),
			'current' => is_page( UTTARAKHAND_TOURS_ABOUT_FLEET_PAGE_SLUG ),
		);
	}

	$contact_url = uttarakhand_tours_get_page_url( UTTARAKHAND_TOURS_CONTACT_PAGE_SLUG );
	if ( $contact_url ) {
		$items[] = array(
			'url'     => $contact_url,
			'label'   => __( 'Contact', 'uttarakhand-tours' ),
			'current' => is_page( UTTARAKHAND_TOURS_CONTACT_PAGE_SLUG ),
		);
	}

	return $items;
}

/**
 * Renders one fallback menu list. `aria-current="page"` marks the visitor's
 * current location for assistive tech, matching the visual active state
 * that `.current-menu-item` gives a real WordPress menu.
 */
function uttarakhand_tours_render_fallback_menu( $list_class ) {
	$items = uttarakhand_tours_default_menu_items();

	if ( empty( $items ) ) {
		return;
	}

	echo '<ul class="' . esc_attr( $list_class ) . '">';

	foreach ( $items as $item ) {
		printf(
			'<li class="menu-item%1$s"><a href="%2$s"%3$s>%4$s</a></li>',
			$item['current'] ? ' current-menu-item' : '',
			esc_url( $item['url'] ),
			$item['current'] ? ' aria-current="page"' : '',
			esc_html( $item['label'] )
		);
	}

	echo '</ul>';
}

function uttarakhand_tours_default_primary_menu() {
	uttarakhand_tours_render_fallback_menu( 'site-nav-list' );
}

function uttarakhand_tours_default_footer_menu() {
	uttarakhand_tours_render_fallback_menu( 'site-footer-nav-list' );
}
