<?php
/**
 * Performance hardening for 3G/4G mountain connections (ticket 13): WebP
 * delivery for generated image sub-sizes, disabling unneeded core/plugin
 * assets, and scoping Contact Form 7's assets to only the pages that embed
 * a form. Explicit lazy-loading for image grids rendered outside the main
 * query loop lives with those grids (inc/package-card.php,
 * inc/testimonials-gallery.php) rather than here — the featured/hero image
 * inside the single package template's own main-loop content already gets
 * correct automatic lazy-loading behavior from WordPress core, with nothing
 * to add.
 */
function uttarakhand_tours_convert_image_subsizes_to_webp( $formats ) {
	$formats['image/jpeg'] = 'image/webp';
	$formats['image/png']  = 'image/webp';

	return $formats;
}
add_filter( 'image_editor_output_format', 'uttarakhand_tours_convert_image_subsizes_to_webp' );

/**
 * Disables WordPress core's emoji-detection script/styles, which load on
 * every page by default regardless of whether the page uses an emoji —
 * unnecessary weight modern browsers don't need for native emoji support.
 */
function uttarakhand_tours_disable_emoji_scripts() {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );
}
add_action( 'init', 'uttarakhand_tours_disable_emoji_scripts' );

/**
 * Contact Form 7 loads its JS/CSS on every front-end page by default, even
 * ones with no form on them. Restrict it to the two page types that
 * actually embed a lead-capture form: single Travel Package pages (the
 * Package Inquiry form) and the Contact page (the Custom Package Request
 * form).
 */
function uttarakhand_tours_current_page_has_a_lead_capture_form() {
	return is_singular( 'travel_package' ) || is_page( UTTARAKHAND_TOURS_CONTACT_PAGE_SLUG );
}
add_filter( 'wpcf7_load_js', 'uttarakhand_tours_current_page_has_a_lead_capture_form' );
add_filter( 'wpcf7_load_css', 'uttarakhand_tours_current_page_has_a_lead_capture_form' );
