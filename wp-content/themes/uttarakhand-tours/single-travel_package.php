<?php
/**
 * Single Travel Package template.
 *
 * Renders the full package detail page: itinerary, inclusions/exclusions,
 * pricing, hotel tier, meal plan, vehicle options, and gallery. Map,
 * advisory callout, WhatsApp, and lead-capture forms are out of scope here
 * (tickets 05-08).
 */

/**
 * Resolves an ACF choice field (select/checkbox) value to its human-readable
 * label, falling back to the raw value if no matching choice is found.
 */
function uttarakhand_tours_get_field_choice_label( $field, $value ) {
	return $field['choices'][ $value ] ?? $value;
}

get_header();

while ( have_posts() ) :
	the_post();

	$post_id = get_the_ID();

	$package_price         = get_field( 'package_price' );
	$package_duration       = get_field( 'package_duration' );
	$pickup_drop_location   = get_field( 'pickup_drop_location' );
	$driver_allowance       = get_field( 'driver_allowance_included' );
	$toll_parking_included  = get_field( 'toll_parking_included' );
	$itinerary_content      = get_field( 'itinerary_content' );
	$inclusions             = get_field( 'inclusions' );
	$exclusions             = get_field( 'exclusions' );

	$vehicle_options_field = get_field_object( 'vehicle_options' );
	$hotel_tier_field      = get_field_object( 'hotel_tier' );
	$meal_plan_field       = get_field_object( 'meal_plan' );

	$regions = get_the_terms( $post_id, 'package_region' );
	$themes  = get_the_terms( $post_id, 'package_theme' );
	?>

	<article <?php post_class(); ?>>
		<h1 class="package-title"><?php the_title(); ?></h1>

		<?php if ( has_post_thumbnail() ) : ?>
			<div class="package-featured-image">
				<?php the_post_thumbnail( 'large' ); ?>
			</div>
		<?php endif; ?>

		<div class="package-gallery">
			<?php the_content(); ?>
		</div>

		<?php if ( $package_price ) : ?>
			<p class="package-price">Starting from &#8377;<?php echo esc_html( number_format_i18n( $package_price ) ); ?></p>
		<?php endif; ?>

		<?php if ( $package_duration ) : ?>
			<p class="package-duration"><?php echo esc_html( $package_duration ); ?></p>
		<?php endif; ?>

		<?php if ( $pickup_drop_location ) : ?>
			<p class="package-pickup-drop-location">Pickup / Drop: <?php echo esc_html( $pickup_drop_location ); ?></p>
		<?php endif; ?>

		<?php if ( ! empty( $regions ) && ! is_wp_error( $regions ) ) : ?>
			<ul class="package-regions">
				<?php foreach ( $regions as $region ) : ?>
					<li class="package-region"><?php echo esc_html( $region->name ); ?></li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>

		<?php if ( ! empty( $themes ) && ! is_wp_error( $themes ) ) : ?>
			<ul class="package-themes">
				<?php foreach ( $themes as $theme ) : ?>
					<li class="package-theme"><?php echo esc_html( $theme->name ); ?></li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>

		<div class="package-vehicle-options">
			<h2>Vehicle Options</h2>
			<?php if ( ! empty( $vehicle_options_field['value'] ) ) : ?>
				<ul>
					<?php foreach ( (array) $vehicle_options_field['value'] as $vehicle_option ) : ?>
						<li><?php echo esc_html( uttarakhand_tours_get_field_choice_label( $vehicle_options_field, $vehicle_option ) ); ?></li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>

			<p class="package-driver-allowance-included">Driver Allowance Included: <?php echo esc_html( $driver_allowance ? 'Yes' : 'No' ); ?></p>
			<p class="package-toll-parking-included">Toll &amp; Parking Included: <?php echo esc_html( $toll_parking_included ? 'Yes' : 'No' ); ?></p>
		</div>

		<?php if ( ! empty( $hotel_tier_field['value'] ) ) : ?>
			<p class="package-hotel-tier">Hotel Tier: <?php echo esc_html( uttarakhand_tours_get_field_choice_label( $hotel_tier_field, $hotel_tier_field['value'] ) ); ?></p>
		<?php endif; ?>

		<?php if ( ! empty( $meal_plan_field['value'] ) ) : ?>
			<p class="package-meal-plan">Meal Plan: <?php echo esc_html( uttarakhand_tours_get_field_choice_label( $meal_plan_field, $meal_plan_field['value'] ) ); ?></p>
		<?php endif; ?>

		<?php if ( $itinerary_content ) : ?>
			<div class="package-itinerary">
				<h2>Itinerary</h2>
				<?php echo wp_kses_post( $itinerary_content ); ?>
			</div>
		<?php endif; ?>

		<?php if ( $inclusions ) : ?>
			<div class="package-inclusions">
				<h2>Inclusions</h2>
				<?php echo wp_kses_post( $inclusions ); ?>
			</div>
		<?php endif; ?>

		<?php if ( $exclusions ) : ?>
			<div class="package-exclusions">
				<h2>Exclusions</h2>
				<?php echo wp_kses_post( $exclusions ); ?>
			</div>
		<?php endif; ?>
	</article>

<?php
endwhile;

get_footer();
