<?php
/**
 * Homepage.
 *
 * Hero search/filter bar (submits into the Package Archive's server-side
 * filtering, ticket 04), featured packages, popular regions, trust badges,
 * and a testimonials/gallery teaser (ticket 09).
 */

get_header();

$archive_url = get_post_type_archive_link( 'travel_package' );

$regions = get_terms(
	array(
		'taxonomy'   => 'package_region',
		'hide_empty' => false,
	)
);
$regions = is_wp_error( $regions ) ? array() : $regions;

$themes = get_terms(
	array(
		'taxonomy'   => 'package_theme',
		'hide_empty' => false,
	)
);
$themes = is_wp_error( $themes ) ? array() : $themes;

$featured_packages = new WP_Query(
	array(
		'post_type'      => 'travel_package',
		'post_status'    => 'publish',
		'posts_per_page' => 6,
		'orderby'        => 'date',
		'order'          => 'DESC',
	)
);

$trust_badges = array(
	'Verified Drivers',
	'Sanitized Cabs',
	'Experienced On Mountain Roads',
	'24/7 Support',
);

$testimonials_html      = uttarakhand_tours_render_testimonials();
$sitewide_gallery_html  = uttarakhand_tours_render_sitewide_gallery();
?>

<section class="homepage-hero">
	<h1>Discover Uttarakhand</h1>

	<form class="hero-filter-form" method="get" action="<?php echo esc_url( $archive_url ); ?>">
		<label>Region
			<select name="region">
				<option value="">Any Region</option>
				<?php foreach ( $regions as $region ) : ?>
					<option value="<?php echo esc_attr( $region->slug ); ?>"><?php echo esc_html( $region->name ); ?></option>
				<?php endforeach; ?>
			</select>
		</label>

		<label>Travel Theme
			<select name="theme">
				<option value="">Any Theme</option>
				<?php foreach ( $themes as $theme ) : ?>
					<option value="<?php echo esc_attr( $theme->slug ); ?>"><?php echo esc_html( $theme->name ); ?></option>
				<?php endforeach; ?>
			</select>
		</label>

		<button type="submit">Search Packages</button>
	</form>
</section>

<section class="homepage-featured-packages">
	<h2>Featured Packages</h2>

	<?php if ( $featured_packages->have_posts() ) : ?>
		<ul class="package-cards">
			<?php
			$card_index = 0;
			while ( $featured_packages->have_posts() ) :
				$featured_packages->the_post();

				// First 3 cards are likely above the fold; match core's own
				// default lazy-loading omit threshold.
				echo uttarakhand_tours_render_package_card( get_the_ID(), $card_index >= 3 );
				++$card_index;
			endwhile;
			wp_reset_postdata();
			?>
		</ul>
	<?php endif; ?>
</section>

<?php if ( ! empty( $regions ) ) : ?>
	<section class="homepage-popular-regions">
		<h2>Popular Regions</h2>

		<ul class="popular-regions">
			<?php foreach ( $regions as $region ) : ?>
				<li class="popular-region">
					<a href="<?php echo esc_url( add_query_arg( 'region', $region->slug, $archive_url ) ); ?>"><?php echo esc_html( $region->name ); ?></a>
				</li>
			<?php endforeach; ?>
		</ul>
	</section>
<?php endif; ?>

<section class="homepage-trust-badges">
	<h2>Why Travel With Us</h2>
	<ul class="trust-badges">
		<?php foreach ( $trust_badges as $trust_badge ) : ?>
			<li class="trust-badge"><?php echo esc_html( $trust_badge ); ?></li>
		<?php endforeach; ?>
	</ul>
</section>

<?php if ( $testimonials_html || $sitewide_gallery_html ) : ?>
	<section class="homepage-testimonials-gallery">
		<?php if ( $testimonials_html ) : ?>
			<h2>What Our Travelers Say</h2>
			<?php echo $testimonials_html; ?>
		<?php endif; ?>

		<?php if ( $sitewide_gallery_html ) : ?>
			<h2>From Our Trips</h2>
			<?php echo $sitewide_gallery_html; ?>
		<?php endif; ?>
	</section>
<?php endif; ?>

<?php
get_footer();
