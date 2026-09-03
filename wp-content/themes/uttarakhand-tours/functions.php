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
require_once __DIR__ . '/inc/about-fleet-page.php';

function uttarakhand_tours_enqueue_styles() {
	wp_enqueue_style( 'uttarakhand-tours-style', get_stylesheet_uri(), array(), wp_get_theme()->get( 'Version' ) );
}
add_action( 'wp_enqueue_scripts', 'uttarakhand_tours_enqueue_styles' );
