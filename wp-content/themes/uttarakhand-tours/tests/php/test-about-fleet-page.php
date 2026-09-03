<?php
/**
 * Tests for the About Us & Fleet/Hotels page (page.php,
 * inc/about-fleet-page.php).
 */
class Test_About_Fleet_Page extends WP_UnitTestCase {

	public function set_up() {
		parent::set_up();
		uttarakhand_tours_seed_about_fleet_page();
	}

	private function render_page( $post_id ) {
		$this->go_to( get_permalink( $post_id ) );

		ob_start();
		include get_stylesheet_directory() . '/page.php';
		return ob_get_clean();
	}

	public function test_seeding_creates_a_published_page_at_the_expected_slug() {
		$page = get_page_by_path( UTTARAKHAND_TOURS_ABOUT_FLEET_PAGE_SLUG );

		$this->assertNotNull( $page );
		$this->assertSame( 'page', $page->post_type );
		$this->assertSame( 'publish', $page->post_status );
		$this->assertStringContainsString( 'About Us', $page->post_title );
		$this->assertStringContainsString( 'Fleet/Hotels', $page->post_title );
	}

	public function test_seeding_is_idempotent() {
		uttarakhand_tours_seed_about_fleet_page();

		$pages = get_posts(
			array(
				'post_type'      => 'page',
				'name'           => UTTARAKHAND_TOURS_ABOUT_FLEET_PAGE_SLUG,
				'post_status'    => 'publish',
				'posts_per_page' => -1,
			)
		);

		$this->assertCount( 1, $pages );
	}

	public function test_page_resolves_with_a_200_and_is_not_a_404() {
		$page = get_page_by_path( UTTARAKHAND_TOURS_ABOUT_FLEET_PAGE_SLUG );

		$this->go_to( get_permalink( $page ) );

		$this->assertQueryTrue( 'is_page', 'is_singular' );
		$this->assertFalse( is_404() );
	}

	public function test_page_renders_all_expected_content_sections() {
		$page = get_page_by_path( UTTARAKHAND_TOURS_ABOUT_FLEET_PAGE_SLUG );

		$html = $this->render_page( $page->ID );

		$this->assertStringContainsString( 'About Us', $html );
		$this->assertStringContainsString( 'Fleet/Hotels', $html );

		$this->assertStringContainsString( 'Our Story', $html );
		$this->assertStringContainsString( 'driving travelers', $html );

		$this->assertStringContainsString( 'Driver Expertise', $html );
		$this->assertStringContainsString( 'mountain-road specialists', $html );

		$this->assertStringContainsString( 'Our Fleet', $html );
		$this->assertStringContainsString( 'sedans, SUVs/Innovas, and tempo travellers', $html );

		$this->assertStringContainsString( 'Partnered Stays', $html );
		$this->assertStringContainsString( 'hotels and homestays', $html );
	}

	public function test_page_content_is_editable_as_plain_page_content_with_no_custom_fields() {
		$post_id = self::factory()->post->create(
			array(
				'post_type'    => 'page',
				'post_status'  => 'publish',
				'post_title'   => 'Custom Editorial Page',
				'post_content' => '<!-- wp:paragraph --><p>Edited by the client.</p><!-- /wp:paragraph -->',
			)
		);

		$html = $this->render_page( $post_id );

		$this->assertStringContainsString( 'Custom Editorial Page', $html );
		$this->assertStringContainsString( 'Edited by the client.', $html );
	}
}
