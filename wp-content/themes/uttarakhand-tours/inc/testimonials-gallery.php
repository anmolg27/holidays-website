<?php
/**
 * Testimonials and the sitewide photo gallery.
 *
 * Testimonials are a `testimonial` CPT (reviewer name as the title, photo as
 * the featured image, quote as the content — registered in
 * inc/post-types.php) — free ACF has no repeater field, so a CPT is the
 * simplest client-manageable mechanism. The sitewide gallery aggregates
 * images straight out of each published Travel Package's existing native
 * gallery (see ticket 02), so the client never uploads photos twice.
 */

/**
 * Renders the published testimonials as a reusable list, suitable for
 * embedding on the homepage. Returns an empty string when there are none,
 * so callers can skip the section entirely rather than rendering an empty
 * shell.
 */
function uttarakhand_tours_render_testimonials() {
	$testimonials = get_posts(
		array(
			'post_type'      => 'testimonial',
			'post_status'    => 'publish',
			'posts_per_page' => -1,
		)
	);

	if ( empty( $testimonials ) ) {
		return '';
	}

	$items_html = '';

	foreach ( $testimonials as $testimonial ) {
		// Explicit loading="lazy": these render from get_posts(), not the main
		// query loop, so WordPress's automatic lazy-loading heuristic never
		// sees them (see inc/package-card.php for the same reasoning).
		$photo = has_post_thumbnail( $testimonial )
			? get_the_post_thumbnail( $testimonial, 'thumbnail', array( 'loading' => 'lazy' ) )
			: '<div class="testimonial-photo-placeholder" aria-hidden="true"></div>';

		$items_html .= sprintf(
			'<li class="testimonial"><div class="testimonial-photo">%s</div><p class="testimonial-name">%s</p><div class="testimonial-quote">%s</div></li>',
			$photo,
			esc_html( get_the_title( $testimonial ) ),
			wp_kses_post( wpautop( $testimonial->post_content ) )
		);
	}

	return '<ul class="testimonials-list">' . $items_html . '</ul>';
}

/**
 * Collects attachment IDs from every published Travel Package's native
 * gallery (a `[gallery]` shortcode in its post content, per ticket 02).
 */
function uttarakhand_tours_get_sitewide_gallery_image_ids() {
	$package_ids = get_posts(
		array(
			'post_type'      => 'travel_package',
			'post_status'    => 'publish',
			'posts_per_page' => -1,
			'fields'         => 'ids',
		)
	);

	$image_ids = array();

	foreach ( $package_ids as $package_id ) {
		$gallery = get_post_gallery( $package_id, false );

		if ( empty( $gallery['ids'] ) ) {
			continue;
		}

		foreach ( explode( ',', $gallery['ids'] ) as $image_id ) {
			$image_ids[] = (int) $image_id;
		}
	}

	return $image_ids;
}

/**
 * Renders the sitewide gallery section. Returns an empty string when no
 * published package has a native gallery image, so callers can skip the
 * section entirely rather than rendering an empty shell.
 */
function uttarakhand_tours_render_sitewide_gallery() {
	$image_ids = uttarakhand_tours_get_sitewide_gallery_image_ids();

	if ( empty( $image_ids ) ) {
		return '';
	}

	$images_html = '';

	foreach ( $image_ids as $image_id ) {
		$images_html .= '<li class="sitewide-gallery-image">' . wp_get_attachment_image( $image_id, 'medium', false, array( 'loading' => 'lazy' ) ) . '</li>';
	}

	return '<ul class="sitewide-gallery">' . $images_html . '</ul>';
}
