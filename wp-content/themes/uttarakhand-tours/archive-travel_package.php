<?php
/**
 * Package Archive template.
 *
 * Lists all published Travel Packages as cards (image, title, region/theme,
 * duration, starting price) with server-side filtering by region, theme,
 * duration, and price via query-string parameters (`region`, `theme`,
 * `duration`, `price_min`, `price_max`). No AJAX/JS filtering — every
 * filtered view is a normal server-rendered page load.
 */

get_header();

$tax_query  = array();
$meta_query = array();

$region = isset( $_GET['region'] ) ? sanitize_title( wp_unslash( $_GET['region'] ) ) : '';
if ( $region ) {
	$tax_query[] = array(
		'taxonomy' => 'package_region',
		'field'    => 'slug',
		'terms'    => $region,
	);
}

$theme = isset( $_GET['theme'] ) ? sanitize_title( wp_unslash( $_GET['theme'] ) ) : '';
if ( $theme ) {
	$tax_query[] = array(
		'taxonomy' => 'package_theme',
		'field'    => 'slug',
		'terms'    => $theme,
	);
}

if ( count( $tax_query ) > 1 ) {
	$tax_query['relation'] = 'AND';
}

$duration = isset( $_GET['duration'] ) ? sanitize_text_field( wp_unslash( $_GET['duration'] ) ) : '';
if ( $duration ) {
	$meta_query[] = array(
		'key'   => 'package_duration',
		'value' => $duration,
	);
}

$price_min = isset( $_GET['price_min'] ) && is_numeric( $_GET['price_min'] ) ? (float) $_GET['price_min'] : null;
$price_max = isset( $_GET['price_max'] ) && is_numeric( $_GET['price_max'] ) ? (float) $_GET['price_max'] : null;

if ( null !== $price_min && null !== $price_max ) {
	$meta_query[] = array(
		'key'     => 'package_price',
		'value'   => array( $price_min, $price_max ),
		'compare' => 'BETWEEN',
		'type'    => 'NUMERIC',
	);
} elseif ( null !== $price_min ) {
	$meta_query[] = array(
		'key'     => 'package_price',
		'value'   => $price_min,
		'compare' => '>=',
		'type'    => 'NUMERIC',
	);
} elseif ( null !== $price_max ) {
	$meta_query[] = array(
		'key'     => 'package_price',
		'value'   => $price_max,
		'compare' => '<=',
		'type'    => 'NUMERIC',
	);
}

if ( count( $meta_query ) > 1 ) {
	$meta_query['relation'] = 'AND';
}

$query_args = array(
	'post_type'      => 'travel_package',
	'post_status'    => 'publish',
	'posts_per_page' => -1,
);

if ( $tax_query ) {
	$query_args['tax_query'] = $tax_query;
}

if ( $meta_query ) {
	$query_args['meta_query'] = $meta_query;
}

$packages = new WP_Query( $query_args );
?>

<div class="package-archive">
	<?php if ( $packages->have_posts() ) : ?>
		<ul class="package-cards">
			<?php
			while ( $packages->have_posts() ) :
				$packages->the_post();

				$post_id          = get_the_ID();
				$package_price    = get_field( 'package_price' );
				$package_duration = get_field( 'package_duration' );
				$regions          = get_the_terms( $post_id, 'package_region' );
				$themes           = get_the_terms( $post_id, 'package_theme' );
				?>
				<li class="package-card">
					<a class="package-card-link" href="<?php the_permalink(); ?>">
						<?php if ( has_post_thumbnail() ) : ?>
							<?php the_post_thumbnail( 'medium' ); ?>
						<?php endif; ?>
						<h2 class="package-card-title"><?php the_title(); ?></h2>
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
			<?php endwhile; ?>
		</ul>
	<?php else : ?>
		<p class="package-archive-empty">No travel packages match your filters.</p>
	<?php endif; ?>
</div>

<?php
wp_reset_postdata();

get_footer();
