<?php
/**
 * Tests for the interactive Route Stops map (inc/route-map.php).
 */
class Test_Route_Map extends WP_UnitTestCase {

	private function render_single_travel_package( $post_id ) {
		$this->go_to( get_permalink( $post_id ) );

		ob_start();
		include get_stylesheet_directory() . '/single-travel_package.php';
		return ob_get_clean();
	}

	public function test_route_stops_are_parsed_in_order_with_coordinates() {
		$raw = "Dehradun | 30.3165, 78.0322\nRishikesh | 30.0869, 78.2676\nDevprayag | 30.1462, 78.5951";

		$stops = uttarakhand_tours_parse_route_stops( $raw );

		$this->assertSame(
			array(
				array( 'name' => 'Dehradun', 'lat' => 30.3165, 'lng' => 78.0322 ),
				array( 'name' => 'Rishikesh', 'lat' => 30.0869, 'lng' => 78.2676 ),
				array( 'name' => 'Devprayag', 'lat' => 30.1462, 'lng' => 78.5951 ),
			),
			$stops
		);
	}

	public function test_malformed_lines_are_skipped_without_erroring() {
		$raw = "Dehradun | 30.3165, 78.0322\nNot a valid line\nRishikesh | not-a-number, 78.2676\n\nDevprayag | 30.1462, 78.5951";

		$stops = uttarakhand_tours_parse_route_stops( $raw );

		$this->assertSame(
			array( 'Dehradun', 'Devprayag' ),
			wp_list_pluck( $stops, 'name' )
		);
	}

	public function test_empty_route_stops_field_parses_to_an_empty_array() {
		$this->assertSame( array(), uttarakhand_tours_parse_route_stops( '' ) );
		$this->assertSame( array(), uttarakhand_tours_parse_route_stops( false ) );
	}

	public function test_single_package_page_renders_map_container_with_marker_data_when_route_stops_set() {
		$post_id = self::factory()->post->create(
			array(
				'post_type'   => 'travel_package',
				'post_status' => 'publish',
				'post_title'  => 'Char Dham Yatra',
			)
		);

		update_field( 'route_stops', "Dehradun | 30.3165, 78.0322\nRishikesh | 30.0869, 78.2676", $post_id );

		$html = $this->render_single_travel_package( $post_id );

		$this->assertStringContainsString( 'id="package-route-map"', $html );

		preg_match( '#data-route-stops="([^"]+)"#', $html, $matches );
		$this->assertNotEmpty( $matches, 'Expected a data-route-stops attribute on the map container.' );

		$route_stops_data = json_decode( html_entity_decode( $matches[1] ), true );

		$this->assertSame(
			array(
				array( 'name' => 'Dehradun', 'lat' => 30.3165, 'lng' => 78.0322 ),
				array( 'name' => 'Rishikesh', 'lat' => 30.0869, 'lng' => 78.2676 ),
			),
			$route_stops_data
		);
	}

	public function test_single_package_page_renders_no_map_when_no_route_stops_are_set() {
		$post_id = self::factory()->post->create(
			array(
				'post_type'   => 'travel_package',
				'post_status' => 'publish',
				'post_title'  => 'Char Dham Yatra',
			)
		);

		$html = $this->render_single_travel_package( $post_id );

		$this->assertStringNotContainsString( 'package-route-map', $html );
	}

	public function test_leaflet_and_map_script_are_enqueued_only_on_single_travel_package_pages() {
		$post_id = self::factory()->post->create(
			array(
				'post_type'   => 'travel_package',
				'post_status' => 'publish',
			)
		);
		$page_id = self::factory()->post->create( array( 'post_type' => 'page' ) );

		$this->go_to( get_permalink( $post_id ) );
		uttarakhand_tours_enqueue_route_map_assets();
		$this->assertTrue( wp_script_is( 'leaflet', 'enqueued' ) );
		$this->assertTrue( wp_script_is( 'uttarakhand-tours-route-map', 'enqueued' ) );

		wp_dequeue_script( 'leaflet' );
		wp_dequeue_script( 'uttarakhand-tours-route-map' );

		$this->go_to( get_permalink( $page_id ) );
		uttarakhand_tours_enqueue_route_map_assets();
		$this->assertFalse( wp_script_is( 'leaflet', 'enqueued' ) );
		$this->assertFalse( wp_script_is( 'uttarakhand-tours-route-map', 'enqueued' ) );
	}

	public function test_map_scripts_are_deferred_so_they_do_not_block_page_rendering() {
		$post_id = self::factory()->post->create(
			array(
				'post_type'   => 'travel_package',
				'post_status' => 'publish',
			)
		);

		$this->go_to( get_permalink( $post_id ) );
		uttarakhand_tours_enqueue_route_map_assets();

		$leaflet   = wp_scripts()->registered['leaflet'];
		$route_map = wp_scripts()->registered['uttarakhand-tours-route-map'];

		$this->assertSame( 'defer', $leaflet->extra['strategy'] );
		$this->assertSame( 'defer', $route_map->extra['strategy'] );
	}
}
