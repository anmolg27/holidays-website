<?php
/**
 * Tests for the archive-travel_package.php template.
 */
class Test_Archive_Travel_Package_Template extends WP_UnitTestCase {

	public function tear_down() {
		$_GET = array();
		parent::tear_down();
	}

	private function create_package( array $args = array() ) {
		return self::factory()->post->create(
			wp_parse_args(
				$args,
				array(
					'post_type'   => 'travel_package',
					'post_status' => 'publish',
				)
			)
		);
	}

	private function render_archive() {
		ob_start();
		include get_stylesheet_directory() . '/archive-travel_package.php';
		return ob_get_clean();
	}

	public function test_archive_url_resolves_and_is_not_a_404() {
		$this->create_package( array( 'post_title' => 'Any Package' ) );

		$this->go_to( get_post_type_archive_link( 'travel_package' ) );

		$this->assertQueryTrue( 'is_archive', 'is_post_type_archive' );
		$this->assertFalse( is_404() );
	}

	public function test_archive_lists_published_packages_with_card_fields() {
		$post_id = $this->create_package( array( 'post_title' => 'Kedarnath Yatra' ) );
		update_field( 'package_price', 12000, $post_id );
		update_field( 'package_duration', '4 Days / 3 Nights', $post_id );
		wp_set_object_terms( $post_id, 'Char Dham', 'package_region' );
		wp_set_object_terms( $post_id, 'Pilgrimage', 'package_theme' );

		$html = $this->render_archive();

		$this->assertStringContainsString( 'Kedarnath Yatra', $html );
		$this->assertStringContainsString( '4 Days / 3 Nights', $html );
		$this->assertStringContainsString( '&#8377;12,000', $html );
		$this->assertStringContainsString( 'Char Dham', $html );
		$this->assertStringContainsString( 'Pilgrimage', $html );
	}

	public function test_filtering_by_region_returns_only_matching_packages() {
		$garhwal_id = $this->create_package( array( 'post_title' => 'Garhwal Package' ) );
		wp_set_object_terms( $garhwal_id, 'Garhwal', 'package_region' );

		$kumaon_id = $this->create_package( array( 'post_title' => 'Kumaon Package' ) );
		wp_set_object_terms( $kumaon_id, 'Kumaon', 'package_region' );

		$_GET = array( 'region' => 'garhwal' );
		$html = $this->render_archive();

		$this->assertStringContainsString( 'Garhwal Package', $html );
		$this->assertStringNotContainsString( 'Kumaon Package', $html );
	}

	public function test_filtering_by_theme_returns_only_matching_packages() {
		$trek_id = $this->create_package( array( 'post_title' => 'Trekking Package' ) );
		wp_set_object_terms( $trek_id, 'Trekking', 'package_theme' );

		$honeymoon_id = $this->create_package( array( 'post_title' => 'Honeymoon Package' ) );
		wp_set_object_terms( $honeymoon_id, 'Honeymoon', 'package_theme' );

		$_GET = array( 'theme' => 'trekking' );
		$html = $this->render_archive();

		$this->assertStringContainsString( 'Trekking Package', $html );
		$this->assertStringNotContainsString( 'Honeymoon Package', $html );
	}

	public function test_filtering_by_duration_returns_only_matching_packages() {
		$short_id = $this->create_package( array( 'post_title' => 'Weekend Getaway' ) );
		update_field( 'package_duration', '2 Days / 1 Night', $short_id );

		$long_id = $this->create_package( array( 'post_title' => 'Grand Char Dham' ) );
		update_field( 'package_duration', '10 Days / 9 Nights', $long_id );

		$_GET = array( 'duration' => '2 Days / 1 Night' );
		$html = $this->render_archive();

		$this->assertStringContainsString( 'Weekend Getaway', $html );
		$this->assertStringNotContainsString( 'Grand Char Dham', $html );
	}

	public function test_filtering_by_price_range_returns_only_matching_packages() {
		$cheap_id = $this->create_package( array( 'post_title' => 'Budget Trip' ) );
		update_field( 'package_price', 5000, $cheap_id );

		$mid_id = $this->create_package( array( 'post_title' => 'Mid Range Trip' ) );
		update_field( 'package_price', 15000, $mid_id );

		$expensive_id = $this->create_package( array( 'post_title' => 'Luxury Trip' ) );
		update_field( 'package_price', 40000, $expensive_id );

		$_GET = array(
			'price_min' => '10000',
			'price_max' => '20000',
		);
		$html = $this->render_archive();

		$this->assertStringContainsString( 'Mid Range Trip', $html );
		$this->assertStringNotContainsString( 'Budget Trip', $html );
		$this->assertStringNotContainsString( 'Luxury Trip', $html );
	}

	public function test_combined_filters_return_the_intersection() {
		$match_id = $this->create_package( array( 'post_title' => 'Garhwal Trekking Deal' ) );
		wp_set_object_terms( $match_id, 'Garhwal', 'package_region' );
		wp_set_object_terms( $match_id, 'Trekking', 'package_theme' );
		update_field( 'package_price', 12000, $match_id );

		$wrong_theme_id = $this->create_package( array( 'post_title' => 'Garhwal Honeymoon Deal' ) );
		wp_set_object_terms( $wrong_theme_id, 'Garhwal', 'package_region' );
		wp_set_object_terms( $wrong_theme_id, 'Honeymoon', 'package_theme' );
		update_field( 'package_price', 12000, $wrong_theme_id );

		$wrong_region_id = $this->create_package( array( 'post_title' => 'Kumaon Trekking Deal' ) );
		wp_set_object_terms( $wrong_region_id, 'Kumaon', 'package_region' );
		wp_set_object_terms( $wrong_region_id, 'Trekking', 'package_theme' );
		update_field( 'package_price', 12000, $wrong_region_id );

		$_GET = array(
			'region'    => 'garhwal',
			'theme'     => 'trekking',
			'price_min' => '10000',
			'price_max' => '15000',
		);
		$html = $this->render_archive();

		$this->assertStringContainsString( 'Garhwal Trekking Deal', $html );
		$this->assertStringNotContainsString( 'Garhwal Honeymoon Deal', $html );
		$this->assertStringNotContainsString( 'Kumaon Trekking Deal', $html );
	}
}
