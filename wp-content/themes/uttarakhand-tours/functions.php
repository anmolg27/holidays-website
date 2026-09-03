<?php
/**
 * Theme bootstrap.
 */

require_once __DIR__ . '/inc/post-types.php';
require_once __DIR__ . '/inc/taxonomies.php';
require_once __DIR__ . '/inc/acf-fields.php';
require_once __DIR__ . '/inc/whatsapp.php';
require_once __DIR__ . '/inc/lead-capture-forms.php';
require_once __DIR__ . '/inc/route-map.php';
require_once __DIR__ . '/inc/testimonials-gallery.php';
require_once __DIR__ . '/inc/package-card.php';
require_once __DIR__ . '/inc/performance.php';
require_once __DIR__ . '/inc/about-fleet-page.php';
require_once __DIR__ . '/inc/contact-page.php';
require_once __DIR__ . '/inc/navigation.php';

/**
 * Core theme supports. `title-tag` in particular was missing, which left
 * every page without a <title> element for browsers, search engines, and
 * shared links.
 */
function uttarakhand_tours_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'custom-logo', array( 'flex-height' => true, 'flex-width' => true ) );
	add_theme_support(
		'html5',
		array( 'search-form', 'gallery', 'caption', 'style', 'script', 'navigation-widgets' )
	);

	register_nav_menus(
		array(
			'primary' => __( 'Primary Menu', 'uttarakhand-tours' ),
			'footer'  => __( 'Footer Menu', 'uttarakhand-tours' ),
		)
	);
}
add_action( 'after_setup_theme', 'uttarakhand_tours_setup' );

/**
 * Two variable webfonts — one display serif, one UI sans — requested as a
 * single stylesheet with `display=swap`, so text paints immediately in the
 * fallback stack on a slow connection and re-renders when the fonts land.
 * Axis ranges (rather than a list of discrete weights) keep this to one
 * file per family instead of one per weight.
 */
function uttarakhand_tours_enqueue_styles() {
	wp_enqueue_style(
		'uttarakhand-tours-fonts',
		'https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,400..700&family=Manrope:wght@400..700&display=swap',
		array(),
		null
	);

	wp_enqueue_style(
		'uttarakhand-tours-style',
		get_stylesheet_uri(),
		array( 'uttarakhand-tours-fonts' ),
		wp_get_theme()->get( 'Version' )
	);
}
add_action( 'wp_enqueue_scripts', 'uttarakhand_tours_enqueue_styles' );

/**
 * WordPress adds a dns-prefetch for fonts.googleapis.com on its own, but
 * the font files themselves come from a second origin. Preconnecting saves
 * a DNS + TLS round trip on the connection speeds this site targets.
 */
function uttarakhand_tours_font_resource_hints( $urls, $relation_type ) {
	if ( 'preconnect' === $relation_type ) {
		$urls[] = array(
			'href'        => 'https://fonts.gstatic.com',
			'crossorigin' => 'anonymous',
		);
	}

	return $urls;
}
add_filter( 'wp_resource_hints', 'uttarakhand_tours_font_resource_hints', 10, 2 );
