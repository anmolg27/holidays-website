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
			$card_index = 0;
			while ( $packages->have_posts() ) :
				$packages->the_post();

				// First 3 cards are likely above the fold; match core's own
				// default lazy-loading omit threshold.
				echo uttarakhand_tours_render_package_card( get_the_ID(), $card_index >= 3 );
				++$card_index;
			endwhile;
			?>
		</ul>
	<?php else : ?>
		<p class="package-archive-empty">No travel packages match your filters.</p>
	<?php endif; ?>
</div>

<?php
wp_reset_postdata();

get_footer();
