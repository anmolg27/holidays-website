<?php
/**
 * Shared Travel Package card markup (image, title, region/theme, duration,
 * starting price), used by both the Package Archive and the homepage's
 * featured packages section.
 */

/**
 * Renders one package card as a `<li>`. Assumes $post_id is a published
 * `travel_package`.
 *
 * $lazy controls the thumbnail's `loading` attribute explicitly, since
 * WordPress's automatic lazy-loading heuristic only tracks images rendered
 * inside the main query loop, and package cards are always rendered from a
 * secondary WP_Query (archive filtering, homepage featured packages) — the
 * heuristic never sees them. Callers should pass `false` for the first few
 * cards in a grid (likely above the fold) and `true` for the rest, mirroring
 * core's own default omit-lazy-loading threshold of 3.
 */
function uttarakhand_tours_render_package_card( $post_id, $lazy = true ) {
	$package_price    = get_field( 'package_price', $post_id );
	$package_duration = get_field( 'package_duration', $post_id );
	$regions          = get_the_terms( $post_id, 'package_region' );
	$themes           = get_the_terms( $post_id, 'package_theme' );

	ob_start();
	?>
	<li class="package-card">
		<a class="package-card-link" href="<?php echo esc_url( get_permalink( $post_id ) ); ?>">
			<?php if ( has_post_thumbnail( $post_id ) ) : ?>
				<?php echo get_the_post_thumbnail( $post_id, 'medium', array( 'loading' => $lazy ? 'lazy' : 'eager' ) ); ?>
			<?php endif; ?>
			<h2 class="package-card-title"><?php echo esc_html( get_the_title( $post_id ) ); ?></h2>
		</a>

		<?php if ( ! empty( $regions ) && ! is_wp_error( $regions ) ) : ?>
			<ul class="package-card-regions">
				<?php foreach ( $regions as $region_term ) : ?>
					<li class="package-card-region"><?php echo esc_html( $region_term->name ); ?></li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>

		<?php if ( ! empty( $themes ) && ! is_wp_error( $themes ) ) : ?>
			<ul class="package-card-themes">
				<?php foreach ( $themes as $theme_term ) : ?>
					<li class="package-card-theme"><?php echo esc_html( $theme_term->name ); ?></li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>

		<?php if ( $package_duration ) : ?>
			<p class="package-card-duration"><?php echo esc_html( $package_duration ); ?></p>
		<?php endif; ?>

		<?php if ( $package_price ) : ?>
			<p class="package-card-price">Starting from &#8377;<?php echo esc_html( number_format_i18n( $package_price ) ); ?></p>
		<?php endif; ?>
	</li>
	<?php
	return ob_get_clean();
}
