<?php
/**
 * ACF (free) field group for the `travel_package` post type.
 *
 * Registered here as a local field group (ACF's PHP export format) rather
 * than as acf-json, so the schema is versioned with the theme and travels
 * across environments without a database sync step.
 */

/**
 * Registers the Travel Package Details field group.
 *
 * Route Stops has no ACF (free) equivalent of a repeater field (Repeater
 * is a Pro-only field type), so it's stored as a plain textarea: one stop
 * per line, formatted as "Place Name | latitude, longitude". This keeps
 * the data plain and makes no assumption about a future live-routing
 * source.
 */
function uttarakhand_tours_register_acf_fields() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	acf_add_local_field_group(
		array(
			'key'      => 'group_travel_package_details',
			'title'    => 'Travel Package Details',
			'fields'   => array(
				array(
					'key'   => 'field_package_price',
					'label' => 'Price (Starting From)',
					'name'  => 'package_price',
					'type'  => 'number',
				),
				array(
					'key'   => 'field_package_duration',
					'label' => 'Duration',
					'name'  => 'package_duration',
					'type'  => 'text',
					'instructions' => 'e.g. "5 Days / 4 Nights"',
				),
				array(
					'key'   => 'field_pickup_drop_location',
					'label' => 'Pickup / Drop Location',
					'name'  => 'pickup_drop_location',
					'type'  => 'text',
				),
				array(
					'key'     => 'field_vehicle_options',
					'label'   => 'Vehicle Options',
					'name'    => 'vehicle_options',
					'type'    => 'checkbox',
					'choices' => array(
						'sedan'           => 'Sedan',
						'suv_innova'      => 'SUV/Innova',
						'tempo_traveller' => 'Tempo Traveller',
					),
				),
				array(
					'key'     => 'field_driver_allowance_included',
					'label'   => 'Driver Allowance Included',
					'name'    => 'driver_allowance_included',
					'type'    => 'true_false',
					'ui'      => 1,
				),
				array(
					'key'     => 'field_toll_parking_included',
					'label'   => 'Toll & Parking Included',
					'name'    => 'toll_parking_included',
					'type'    => 'true_false',
					'ui'      => 1,
				),
				array(
					'key'     => 'field_hotel_tier',
					'label'   => 'Hotel Tier',
					'name'    => 'hotel_tier',
					'type'    => 'select',
					'choices' => array(
						'standard' => 'Standard',
						'deluxe'   => 'Deluxe',
						'luxury'   => 'Luxury',
					),
				),
				array(
					'key'     => 'field_meal_plan',
					'label'   => 'Meal Plan',
					'name'    => 'meal_plan',
					'type'    => 'select',
					'choices' => array(
						'ep'  => 'EP',
						'cp'  => 'CP',
						'map' => 'MAP',
					),
				),
				array(
					'key'   => 'field_itinerary_content',
					'label' => 'Itinerary',
					'name'  => 'itinerary_content',
					'type'  => 'wysiwyg',
				),
				array(
					'key'   => 'field_inclusions',
					'label' => 'Inclusions',
					'name'  => 'inclusions',
					'type'  => 'wysiwyg',
				),
				array(
					'key'   => 'field_exclusions',
					'label' => 'Exclusions',
					'name'  => 'exclusions',
					'type'  => 'wysiwyg',
				),
				array(
					'key'          => 'field_route_stops',
					'label'        => 'Route Stops',
					'name'         => 'route_stops',
					'type'         => 'textarea',
					'instructions' => 'One stop per line, in journey order: "Place Name | latitude, longitude".',
				),
				array(
					'key'   => 'field_mountain_advisory_content',
					'label' => 'Mountain Advisory',
					'name'  => 'mountain_advisory_content',
					'type'  => 'wysiwyg',
					'instructions' => 'Road conditions, monsoon/weather updates, permit requirements, and recommended gear for this package\'s route. Manually written and updated — not pulled from a live feed.',
				),
			),
			'location' => array(
				array(
					array(
						'param'    => 'post_type',
						'operator' => '==',
						'value'    => 'travel_package',
					),
				),
			),
		)
	);
}
add_action( 'acf/init', 'uttarakhand_tours_register_acf_fields' );
