<?php
/**
 * Tests for the homepage (front-page.php).
 */
class Test_Homepage extends WP_UnitTestCase {

	public function set_up() {
		parent::set_up();
		uttarakhand_tours_seed_default_taxonomy_terms();
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

	private function render_homepage() {
		$this->go_to( home_url( '/' ) );

		ob_start();
		include get_stylesheet_directory() . '/front-page.php';
		return ob_get_clean();
	}

	public function test_homepage_resolves_as_the_front_page() {
		$this->go_to( home_url( '/' ) );

		$this->assertTrue( is_front_page() );
		$this->assertFalse( is_404() );
	}

	public function test_hero_filter_bar_submits_to_the_archive_with_matching_query_parameter_names() {
		$html = $this->render_homepage();

		$archive_url = get_post_type_archive_link( 'travel_package' );

		$this->assertStringContainsString( '<form class="hero-filter-form" method="get" action="' . esc_url( $archive_url ) . '">', $html );
		$this->assertStringContainsString( '<select name="region">', $html );
		$this->assertStringContainsString( '<select name="theme">', $html );

		foreach ( array( 'Garhwal', 'Kumaon', 'Char Dham', 'Border circuits' ) as $region_name ) {
			$this->assertStringContainsString( '<option value="' . sanitize_title( $region_name ) . '">' . esc_html( $region_name ) . '</option>', $html );
		}

		foreach ( array( 'Pilgrimage', 'Trekking', 'Honeymoon', 'Family', 'Weekend' ) as $theme_name ) {
			$this->assertStringContainsString( '<option value="' . sanitize_title( $theme_name ) . '">' . esc_html( $theme_name ) . '</option>', $html );
		}
	}

	public function test_featured_packages_section_lists_published_packages_as_cards() {
		$this->create_package( array( 'post_title' => 'Kedarnath Yatra' ) );

		$html = $this->render_homepage();

		$this->assertStringContainsString( 'class="homepage-featured-packages"', $html );
		$this->assertStringContainsString( 'class="package-card"', $html );
		$this->assertStringContainsString( 'Kedarnath Yatra', $html );
	}

	public function test_popular_regions_section_links_to_the_archive_pre_filtered_by_region() {
		$html = $this->render_homepage();

		$archive_url = get_post_type_archive_link( 'travel_package' );

		$this->assertStringContainsString( 'class="homepage-popular-regions"', $html );
		$this->assertStringContainsString(
			esc_url( add_query_arg( 'region', 'garhwal', $archive_url ) ),
			$html
		);
		$this->assertStringContainsString( 'Garhwal', $html );
	}

	public function test_trust_badges_are_displayed() {
		$html = $this->render_homepage();

		$this->assertStringContainsString( 'class="trust-badges"', $html );
		$this->assertStringContainsString( 'Verified Drivers', $html );
	}

	public function test_testimonials_and_gallery_teaser_render_when_content_exists() {
		self::factory()->post->create(
			array(
				'post_type'    => 'testimonial',
				'post_status'  => 'publish',
				'post_title'   => 'Priya Sharma',
				'post_content' => 'Wonderful trip, highly recommended.',
			)
		);

		$package_id = $this->create_package( array( 'post_title' => 'Valley of Flowers Trek' ) );
		$image_id   = self::factory()->attachment->create_upload_object( DIR_TESTDATA . '/images/canola.jpg', $package_id );
		wp_update_post(
			array(
				'ID'           => $package_id,
				'post_content' => '[gallery ids="' . $image_id . '"]',
			)
		);

		$html = $this->render_homepage();

		$this->assertStringContainsString( 'class="homepage-testimonials-gallery"', $html );
		$this->assertStringContainsString( 'Priya Sharma', $html );
		$this->assertStringContainsString( 'Wonderful trip, highly recommended.', $html );
		$this->assertStringContainsString( wp_get_attachment_image_url( $image_id, 'medium' ), $html );
	}

	public function test_testimonials_and_gallery_teaser_is_omitted_when_no_content_exists() {
		$html = $this->render_homepage();

		$this->assertStringNotContainsString( 'homepage-testimonials-gallery', $html );
	}
}
