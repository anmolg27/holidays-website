<?php
/**
 * Tests for the single-travel_package.php template.
 */
class Test_Single_Travel_Package_Template extends WP_UnitTestCase {

	private function render_single_travel_package( $post_id ) {
		$this->go_to( get_permalink( $post_id ) );

		ob_start();
		include get_stylesheet_directory() . '/single-travel_package.php';
		return ob_get_clean();
	}

	public function test_single_travel_package_url_resolves_and_is_not_a_404() {
		$post_id = self::factory()->post->create(
			array(
				'post_type'   => 'travel_package',
				'post_status' => 'publish',
				'post_title'  => 'Valley of Flowers Trek',
			)
		);

		$this->go_to( get_permalink( $post_id ) );

		$this->assertQueryTrue( 'is_single', 'is_singular' );
		$this->assertFalse( is_404() );
	}

	public function test_single_travel_package_template_renders_all_fields() {
		$post_id = self::factory()->post->create(
			array(
				'post_type'   => 'travel_package',
				'post_status' => 'publish',
				'post_title'  => 'Valley of Flowers Trek',
			)
		);

		$thumbnail_id = self::factory()->attachment->create_upload_object(
			DIR_TESTDATA . '/images/canola.jpg',
			$post_id
		);
		set_post_thumbnail( $post_id, $thumbnail_id );

		$gallery_image_id = self::factory()->attachment->create_upload_object(
			DIR_TESTDATA . '/images/test-image.jpg',
			$post_id
		);
		wp_update_post(
			array(
				'ID'           => $post_id,
				'post_content' => '[gallery ids="' . $gallery_image_id . '"]',
			)
		);

		update_field( 'package_price', 18500, $post_id );
		update_field( 'package_duration', '5 Days / 4 Nights', $post_id );
		update_field( 'pickup_drop_location', 'Dehradun Railway Station', $post_id );
		update_field( 'vehicle_options', array( 'suv_innova', 'tempo_traveller' ), $post_id );
		update_field( 'driver_allowance_included', true, $post_id );
		update_field( 'toll_parking_included', true, $post_id );
		update_field( 'hotel_tier', 'deluxe', $post_id );
		update_field( 'meal_plan', 'map', $post_id );
		update_field( 'itinerary_content', '<p>Day 1: Arrive in Dehradun.</p>', $post_id );
		update_field( 'inclusions', '<p>Cab, hotel, breakfast, dinner.</p>', $post_id );
		update_field( 'exclusions', '<p>Personal expenses, entry fees.</p>', $post_id );

		wp_set_object_terms( $post_id, 'Char Dham', 'package_region' );
		wp_set_object_terms( $post_id, 'Pilgrimage', 'package_theme' );

		$html = $this->render_single_travel_package( $post_id );

		$this->assertStringContainsString( 'Valley of Flowers Trek', $html );
		$this->assertStringContainsString( wp_get_attachment_image_url( $thumbnail_id, 'large' ), $html );
		$this->assertStringContainsString( wp_get_attachment_image_url( $gallery_image_id, 'thumbnail' ), $html );

		$this->assertStringContainsString( '&#8377;18,500', $html );
		$this->assertStringContainsString( '5 Days / 4 Nights', $html );
		$this->assertStringContainsString( 'Dehradun Railway Station', $html );

		$this->assertStringContainsString( 'SUV/Innova', $html );
		$this->assertStringContainsString( 'Tempo Traveller', $html );
		$this->assertStringContainsString( 'Driver Allowance Included: Yes', $html );
		$this->assertStringContainsString( 'Toll &amp; Parking Included: Yes', $html );

		$this->assertStringContainsString( 'Deluxe', $html );
		$this->assertStringContainsString( 'MAP', $html );

		$this->assertStringContainsString( 'Day 1: Arrive in Dehradun.', $html );
		$this->assertStringContainsString( 'Cab, hotel, breakfast, dinner.', $html );
		$this->assertStringContainsString( 'Personal expenses, entry fees.', $html );

		$this->assertStringContainsString( 'Char Dham', $html );
		$this->assertStringContainsString( 'Pilgrimage', $html );
	}
}
