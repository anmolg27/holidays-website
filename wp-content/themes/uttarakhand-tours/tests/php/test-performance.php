<?php
/**
 * Tests for the performance/responsiveness hardening pass (ticket 13):
 * WebP image sub-sizes and script enqueueing scoped to where it's needed.
 */
class Test_Performance extends WP_UnitTestCase {

	public function set_up() {
		parent::set_up();

		// Scripts persist as global state across tests within a run; reset
		// so each test observes only what it itself enqueues.
		global $wp_scripts;
		$wp_scripts = new WP_Scripts();
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

	public function test_generated_jpeg_and_png_subsizes_are_converted_to_webp() {
		$formats = apply_filters( 'image_editor_output_format', array(), 'photo.jpg', 'image/jpeg' );

		$this->assertSame( 'image/webp', $formats['image/jpeg'] );
		$this->assertSame( 'image/webp', $formats['image/png'] );
	}

	public function test_route_map_assets_are_not_enqueued_on_the_homepage() {
		$this->go_to( home_url( '/' ) );
		do_action( 'wp_enqueue_scripts' );

		$this->assertFalse( wp_script_is( 'leaflet', 'enqueued' ) );
		$this->assertFalse( wp_script_is( 'uttarakhand-tours-route-map', 'enqueued' ) );
	}

	public function test_route_map_assets_are_not_enqueued_on_the_archive() {
		$this->create_package();

		$this->go_to( get_post_type_archive_link( 'travel_package' ) );
		do_action( 'wp_enqueue_scripts' );

		$this->assertFalse( wp_script_is( 'leaflet', 'enqueued' ) );
		$this->assertFalse( wp_script_is( 'uttarakhand-tours-route-map', 'enqueued' ) );
	}

	// Route map assets ARE expected to load on a single package page — see
	// test-route-map.php's own coverage of that case.

	public function test_wp_core_emoji_scripts_are_disabled() {
		$this->assertFalse( has_action( 'wp_head', 'print_emoji_detection_script' ) );
		$this->assertFalse( has_action( 'wp_print_styles', 'print_emoji_styles' ) );
	}

	public function test_contact_form_7_assets_load_only_on_pages_with_a_lead_capture_form() {
		uttarakhand_tours_seed_contact_page();

		$post_id = $this->create_package();
		$this->go_to( get_permalink( $post_id ) );
		$this->assertTrue( uttarakhand_tours_current_page_has_a_lead_capture_form() );

		$contact_page = get_page_by_path( UTTARAKHAND_TOURS_CONTACT_PAGE_SLUG );
		$this->go_to( get_permalink( $contact_page ) );
		$this->assertTrue( uttarakhand_tours_current_page_has_a_lead_capture_form() );

		$this->go_to( get_post_type_archive_link( 'travel_package' ) );
		$this->assertFalse( uttarakhand_tours_current_page_has_a_lead_capture_form() );

		$this->go_to( home_url( '/' ) );
		$this->assertFalse( uttarakhand_tours_current_page_has_a_lead_capture_form() );
	}

	public function test_images_below_the_fold_use_lazy_loading_but_the_first_cards_stay_eager() {
		for ( $i = 0; $i < 6; $i++ ) {
			$package_id = $this->create_package( array( 'post_title' => "Package $i" ) );
			$image_id   = self::factory()->attachment->create_upload_object( DIR_TESTDATA . '/images/canola.jpg', $package_id );
			set_post_thumbnail( $package_id, $image_id );
		}

		$this->go_to( home_url( '/' ) );

		ob_start();
		include get_stylesheet_directory() . '/front-page.php';
		$html = ob_get_clean();

		$this->assertStringContainsString( 'loading="lazy"', $html );
		$this->assertStringContainsString( 'loading="eager"', $html );
	}
}
