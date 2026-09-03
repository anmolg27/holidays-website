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

$archive_url = get_post_type_archive_link( 'travel_package' );

$region_terms = get_terms(
	array(
		'taxonomy'   => 'package_region',
		'hide_empty' => false,
	)
);
$region_terms = is_wp_error( $region_terms ) ? array() : $region_terms;

$theme_terms = get_terms(
	array(
		'taxonomy'   => 'package_theme',
		'hide_empty' => false,
	)
);
$theme_terms = is_wp_error( $theme_terms ) ? array() : $theme_terms;

$has_active_filters = ( '' !== $region || '' !== $theme || '' !== $duration || null !== $price_min || null !== $price_max );

/**
 * The filter bar only exposes region and theme — the same two parameters
 * the homepage hero submits. Any duration/price filter already in the URL
 * rides along as a hidden field, so narrowing by region never silently
 * discards a filter the visitor arrived with.
 */
$carried_filters = array(
	'duration'  => $duration,
	'price_min' => null !== $price_min ? $price_min : '',
	'price_max' => null !== $price_max ? $price_max : '',
);
?>

<div class="package-archive">
	<header class="package-archive-header">
		<h1 class="page-title"><?php echo esc_html( get_post_type_object( 'travel_package' )->labels->name ); ?></h1>

		<p class="package-archive-lede">Every package below combines the cab, the stay and a day-by-day plan. Narrow by region or travel theme, then send an inquiry — we confirm the details with you directly.</p>

		<form class="package-archive-filters" method="get" action="<?php echo esc_url( $archive_url ); ?>">
			<label class="package-archive-field"><span class="package-archive-label">Region</span>
				<select name="region">
					<option value="">Any region</option>
					<?php foreach ( $region_terms as $region_term ) : ?>
						<option value="<?php echo esc_attr( $region_term->slug ); ?>"<?php selected( $region, $region_term->slug ); ?>><?php echo esc_html( $region_term->name ); ?></option>
					<?php endforeach; ?>
				</select>
			</label>

			<label class="package-archive-field"><span class="package-archive-label">Travel theme</span>
				<select name="theme">
					<option value="">Any theme</option>
					<?php foreach ( $theme_terms as $theme_term ) : ?>
						<option value="<?php echo esc_attr( $theme_term->slug ); ?>"<?php selected( $theme, $theme_term->slug ); ?>><?php echo esc_html( $theme_term->name ); ?></option>
					<?php endforeach; ?>
				</select>
			</label>

			<?php foreach ( $carried_filters as $carried_name => $carried_value ) : ?>
				<?php if ( '' !== $carried_value ) : ?>
					<input type="hidden" name="<?php echo esc_attr( $carried_name ); ?>" value="<?php echo esc_attr( $carried_value ); ?>">
				<?php endif; ?>
			<?php endforeach; ?>

			<button type="submit">Apply filters</button>
		</form>

		<p class="package-archive-count">
			<span><?php echo esc_html( sprintf( _n( '%s package', '%s packages', $packages->post_count, 'uttarakhand-tours' ), number_format_i18n( $packages->post_count ) ) ); ?></span>

			<?php if ( $has_active_filters ) : ?>
				<a class="package-archive-clear" href="<?php echo esc_url( $archive_url ); ?>">Clear filters</a>
			<?php endif; ?>
		</p>
	</header>

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
		<div class="package-archive-empty">
			<p class="package-archive-empty-title">No travel packages match your filters.</p>
			<p>Widening the region or travel theme usually turns something up. If you already know the route you want, tell us and we will put a package together for it.</p>

			<div class="package-archive-empty-actions">
				<a class="package-archive-clear" href="<?php echo esc_url( $archive_url ); ?>">Clear filters</a>
			</div>
		</div>
	<?php endif; ?>
</div>

<?php
wp_reset_postdata();

get_footer();
