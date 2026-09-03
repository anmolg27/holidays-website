<?php
/**
 * Tests for the ACF (free) field group on the `travel_package` post type.
 */
class Test_Acf_Fields extends WP_UnitTestCase {

	public function test_acf_is_loaded_and_field_group_is_registered() {
		$this->assertTrue( function_exists( 'acf_add_local_field_group' ) );

		$field_group = acf_get_field_group( 'group_travel_package_details' );

		$this->assertNotFalse( $field_group );
	}

	public function test_all_travel_package_fields_persist_and_are_retrievable() {
		$post_id = self::factory()->post->create(
			array(
				'post_type'   => 'travel_package',
				'post_status' => 'publish',
				'post_title'  => 'Valley of Flowers Trek',
			)
		);

		$values = array(
			'package_price'              => 18500,
			'package_duration'           => '5 Days / 4 Nights',
			'pickup_drop_location'       => 'Dehradun Railway Station',
			'vehicle_options'            => array( 'suv_innova', 'tempo_traveller' ),
			'driver_allowance_included'  => true,
			'toll_parking_included'      => true,
			'hotel_tier'                 => 'deluxe',
			'meal_plan'                  => 'map',
			'itinerary_content'          => '<p>Day 1: Arrive in Dehradun.</p>',
			'inclusions'                 => '<p>Cab, hotel, breakfast, dinner.</p>',
			'exclusions'                 => '<p>Personal expenses, entry fees.</p>',
			'route_stops'                => "Dehradun | 30.3165, 78.0322\nJoshimath | 30.5610, 79.5658",
			'mountain_advisory_content'  => '<p>Road open, carry monsoon gear.</p>',
		);

		foreach ( $values as $field_name => $value ) {
			update_field( $field_name, $value, $post_id );
		}

		foreach ( $values as $field_name => $expected ) {
			$actual = get_field( $field_name, $post_id );

			if ( is_string( $actual ) ) {
				$actual = rtrim( $actual );
			}

			$this->assertEquals(
				$expected,
				$actual,
				"Expected field '{$field_name}' to persist and be retrievable."
			);
		}
	}
}
