<?php
/**
 * Single Travel Package template.
 *
 * Renders the full package detail page: itinerary, inclusions/exclusions,
 * pricing, hotel tier, meal plan, vehicle options, gallery, WhatsApp
 * click-to-chat, the package inquiry form, the Route Stops map, and the
 * Mountain Advisory callout.
 */

/**
 * Resolves an ACF choice field (select/checkbox) value to its human-readable
 * label, falling back to the raw value if no matching choice is found.
 */
if ( ! function_exists( 'uttarakhand_tours_get_field_choice_label' ) ) {
	function uttarakhand_tours_get_field_choice_label( $field, $value ) {
		return $field['choices'][ $value ] ?? $value;
	}
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
	$mountain_advisory_content = get_field( 'mountain_advisory_content' );

	$vehicle_options_field = get_field_object( 'vehicle_options' );
	$hotel_tier_field      = get_field_object( 'hotel_tier' );
	$meal_plan_field       = get_field_object( 'meal_plan' );

	$regions = get_the_terms( $post_id, 'package_region' );
	$themes  = get_the_terms( $post_id, 'package_theme' );

	$route_stops = uttarakhand_tours_parse_route_stops( get_field( 'route_stops' ) );

	$package_title         = get_the_title( $post_id );
	$whatsapp_floating_link = uttarakhand_tours_get_whatsapp_link( sprintf( "Hi, I'm interested in the %s package.", $package_title ) );
	$whatsapp_inquire_link  = uttarakhand_tours_get_whatsapp_link( sprintf( "Hi, I'd like to enquire about the %s package.", $package_title ) );
	?>

	<?php if ( $whatsapp_floating_link ) : ?>
		<a class="whatsapp-floating-button" href="<?php echo esc_url( $whatsapp_floating_link ); ?>" target="_blank" rel="noopener noreferrer">Chat on WhatsApp</a>
	<?php endif; ?>

	<article <?php post_class(); ?>>
		<header class="package-hero<?php echo has_post_thumbnail() ? '' : ' package-hero-without-image'; ?>">
			<div class="package-hero-copy">
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

				<h1 class="package-title"><?php the_title(); ?></h1>

				<div class="package-summary">
					<?php if ( $package_price ) : ?>
						<p class="package-price">Starting from &#8377;<?php echo esc_html( number_format_i18n( $package_price ) ); ?></p>
					<?php endif; ?>

					<?php if ( $package_duration ) : ?>
						<p class="package-duration"><?php echo esc_html( $package_duration ); ?></p>
					<?php endif; ?>

					<?php if ( $pickup_drop_location ) : ?>
						<p class="package-pickup-drop-location">Pickup / Drop: <?php echo esc_html( $pickup_drop_location ); ?></p>
					<?php endif; ?>
				</div>
			</div>

			<?php if ( has_post_thumbnail() ) : ?>
				<div class="package-featured-image">
					<?php the_post_thumbnail( 'large' ); ?>
				</div>
			<?php endif; ?>
		</header>

		<div class="package-detail-layout">
			<aside class="package-detail-sidebar" aria-label="<?php esc_attr_e( 'Package essentials', 'uttarakhand-tours' ); ?>">
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

				<?php if ( ! empty( $hotel_tier_field['value'] ) || ! empty( $meal_plan_field['value'] ) ) : ?>
					<div class="package-stay-details">
						<?php if ( ! empty( $hotel_tier_field['value'] ) ) : ?>
							<p class="package-hotel-tier">Hotel Tier: <?php echo esc_html( uttarakhand_tours_get_field_choice_label( $hotel_tier_field, $hotel_tier_field['value'] ) ); ?></p>
						<?php endif; ?>

						<?php if ( ! empty( $meal_plan_field['value'] ) ) : ?>
							<p class="package-meal-plan">Meal Plan: <?php echo esc_html( uttarakhand_tours_get_field_choice_label( $meal_plan_field, $meal_plan_field['value'] ) ); ?></p>
						<?php endif; ?>
					</div>
				<?php endif; ?>

				<?php if ( $whatsapp_inquire_link ) : ?>
					<a class="whatsapp-inquire-cta" href="<?php echo esc_url( $whatsapp_inquire_link ); ?>" target="_blank" rel="noopener noreferrer">Inquire About This Package</a>
				<?php endif; ?>
			</aside>

			<div class="package-detail-main">
				<div class="package-gallery">
					<?php the_content(); ?>
				</div>

				<?php if ( $itinerary_content ) : ?>
					<section class="package-itinerary">
						<h2>Itinerary</h2>
						<?php echo wp_kses_post( $itinerary_content ); ?>
					</section>
				<?php endif; ?>

				<?php if ( $route_stops ) : ?>
					<section class="package-route">
						<h2>Route</h2>
						<?php
						// The map container's own markup, safely built by uttarakhand_tours_render_route_map().
						echo uttarakhand_tours_render_route_map( $route_stops );
						?>
					</section>
				<?php endif; ?>

				<?php if ( $mountain_advisory_content ) : ?>
					<aside class="package-mountain-advisory">
						<h2>Mountain Advisory</h2>
						<?php echo wp_kses_post( $mountain_advisory_content ); ?>
					</aside>
				<?php endif; ?>

				<?php if ( $inclusions || $exclusions ) : ?>
					<div class="package-inclusions-grid">
						<?php if ( $inclusions ) : ?>
							<section class="package-inclusions">
								<h2>Inclusions</h2>
								<?php echo wp_kses_post( $inclusions ); ?>
							</section>
						<?php endif; ?>

						<?php if ( $exclusions ) : ?>
							<section class="package-exclusions">
								<h2>Exclusions</h2>
								<?php echo wp_kses_post( $exclusions ); ?>
							</section>
						<?php endif; ?>
					</div>
				<?php endif; ?>
			</div>
		</div>

		<section class="package-inquiry-form">
			<h2>Inquire About This Package</h2>
			<p>Share your travel dates and group details. The local team will follow up to shape the journey with you.</p>
			<?php
			// Contact Form 7's own form_html() output — trusted plugin markup, not user input.
			echo uttarakhand_tours_render_package_inquiry_form( $post_id, $package_title );
			?>
		</section>
	</article>

<?php
endwhile;

get_footer();
