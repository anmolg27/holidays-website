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
		$photo = has_post_thumbnail( $testimonial ) ? get_the_post_thumbnail( $testimonial, 'thumbnail', array( 'loading' => 'lazy' ) ) : '';

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
 * Collects gallery images from every published Travel Package (a `[gallery]`
 * shortcode in its post content, per ticket 02), keeping each image paired
 * with the package it came from so the sitewide gallery can send a visitor
 * from a photo to the trip it was taken on.
 */
function uttarakhand_tours_get_sitewide_gallery_images() {
	$package_ids = get_posts(
		array(
			'post_type'      => 'travel_package',
			'post_status'    => 'publish',
			'posts_per_page' => -1,
			'fields'         => 'ids',
		)
	);

	$images = array();

	foreach ( $package_ids as $package_id ) {
		$gallery = get_post_gallery( $package_id, false );

		if ( empty( $gallery['ids'] ) ) {
			continue;
		}

		foreach ( explode( ',', $gallery['ids'] ) as $image_id ) {
			$images[] = array(
				'image_id'   => (int) $image_id,
				'package_id' => (int) $package_id,
			);
		}
	}

	return $images;
}

/**
 * Renders the sitewide gallery section. Returns an empty string when no
 * published package has a native gallery image, so callers can skip the
 * section entirely rather than rendering an empty shell.
 *
 * Clicking a photo opens the photo. The link points at the `large` size
 * rather than the untouched original: `large` is a generated sub-size, so
 * inc/performance.php has already converted it to WebP, and on a 3G
 * mountain connection that is a few hundred kilobytes instead of whatever
 * came off the client's camera.
 *
 * Gallery attachments frequently carry no alt text, which would leave the
 * link with no accessible name at all, so the label falls back to naming
 * the package the photo came from.
 */
function uttarakhand_tours_render_sitewide_gallery() {
	$images = uttarakhand_tours_get_sitewide_gallery_images();

	if ( empty( $images ) ) {
		return '';
	}

	$images_html = '';

	foreach ( $images as $image ) {
		$alt = trim( (string) get_post_meta( $image['image_id'], '_wp_attachment_image_alt', true ) );

		if ( '' !== $alt ) {
			/* translators: %s: the photo's alt text. */
			$label = sprintf( __( 'Open the full photo: %s', 'uttarakhand-tours' ), $alt );
		} else {
			/* translators: %s: Travel Package title. */
			$label = sprintf( __( 'Open a full photo from the %s package', 'uttarakhand-tours' ), get_the_title( $image['package_id'] ) );
		}

		$images_html .= sprintf(
			'<li class="sitewide-gallery-image"><a class="sitewide-gallery-link" href="%1$s" aria-label="%2$s">%3$s</a></li>',
			esc_url( wp_get_attachment_image_url( $image['image_id'], 'large' ) ),
			esc_attr( $label ),
			wp_get_attachment_image( $image['image_id'], 'medium', false, array( 'loading' => 'lazy' ) )
		);
	}

	return '<ul class="sitewide-gallery">' . $images_html . '</ul>';
}

/**
 * WordPress links each `[gallery]` thumbnail to its attachment page by
 * default. This theme ships no attachment template, so that drops the
 * visitor onto the bare index.php fallback with no route back into the
 * trip. Point unconfigured galleries at the image file instead; an explicit
 * link="..." in the shortcode still wins.
 */
function uttarakhand_tours_default_gallery_link_to_file( $out, $pairs, $atts ) {
	if ( ! isset( $atts['link'] ) ) {
		$out['link'] = 'file';
	}

	return $out;
}
add_filter( 'shortcode_atts_gallery', 'uttarakhand_tours_default_gallery_link_to_file', 10, 3 );
