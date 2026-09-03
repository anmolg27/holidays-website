<?php
/**
 * Tests for the Contact page (page-contact.php, inc/contact-page.php).
 */
class Test_Contact_Page extends WP_UnitTestCase {

	public function set_up() {
		parent::set_up();
		uttarakhand_tours_seed_contact_page();
		uttarakhand_tours_seed_lead_capture_forms();
	}

	public function tearDown(): void {
		remove_theme_mod( 'uttarakhand_tours_whatsapp_number' );
		remove_theme_mod( 'uttarakhand_tours_contact_phone' );
		remove_theme_mod( 'uttarakhand_tours_contact_email' );
		remove_theme_mod( 'uttarakhand_tours_contact_address' );
		parent::tearDown();
	}

	private function render_contact_page() {
		$page = get_page_by_path( UTTARAKHAND_TOURS_CONTACT_PAGE_SLUG );

		$this->go_to( get_permalink( $page ) );

		ob_start();
		include get_stylesheet_directory() . '/page-contact.php';
		return ob_get_clean();
	}

	public function test_seeding_creates_a_published_page_at_the_expected_slug() {
		$page = get_page_by_path( UTTARAKHAND_TOURS_CONTACT_PAGE_SLUG );

		$this->assertNotNull( $page );
		$this->assertSame( 'page', $page->post_type );
		$this->assertSame( 'publish', $page->post_status );
	}

	public function test_seeding_is_idempotent() {
		uttarakhand_tours_seed_contact_page();

		$pages = get_posts(
			array(
				'post_type'      => 'page',
				'name'           => UTTARAKHAND_TOURS_CONTACT_PAGE_SLUG,
				'post_status'    => 'publish',
				'posts_per_page' => -1,
			)
		);

		$this->assertCount( 1, $pages );
	}

	public function test_page_resolves_with_a_200_and_is_not_a_404() {
		$page = get_page_by_path( UTTARAKHAND_TOURS_CONTACT_PAGE_SLUG );

		$this->go_to( get_permalink( $page ) );

		$this->assertQueryTrue( 'is_page', 'is_singular' );
		$this->assertFalse( is_404() );
	}

	public function test_page_embeds_the_custom_package_request_form() {
		$html = $this->render_contact_page();

		$this->assertStringContainsString( 'name="region"', $html );
		$this->assertStringContainsString( 'name="travel-start-date"', $html );
		$this->assertStringContainsString( 'name="travel-duration"', $html );
		$this->assertStringContainsString( 'name="passenger-count"', $html );
		$this->assertStringContainsString( 'name="vehicle-preference"', $html );
		$this->assertStringContainsString( 'name="accommodation-tier"', $html );
		$this->assertStringContainsString( 'name="notes"', $html );
		$this->assertStringNotContainsStringIgnoringCase( 'price', $html );
	}

	public function test_page_includes_a_correctly_formed_whatsapp_link() {
		set_theme_mod( 'uttarakhand_tours_whatsapp_number', '+91 98765 43210' );

		$html = $this->render_contact_page();

		$this->assertMatchesRegularExpression(
			'#<a[^>]+class="whatsapp-contact-cta"[^>]+href="([^"]+)"#',
			$html
		);
		preg_match( '#<a[^>]+class="whatsapp-contact-cta"[^>]+href="([^"]+)"#', $html, $matches );

		$href = html_entity_decode( $matches[1] );

		$this->assertStringContainsString( 'https://wa.me/919876543210', $href );
	}

	public function test_whatsapp_link_is_absent_when_no_number_is_configured() {
		$html = $this->render_contact_page();

		$this->assertStringNotContainsString( 'whatsapp-contact-cta', $html );
	}

	public function test_contact_details_render_when_configured() {
		set_theme_mod( 'uttarakhand_tours_contact_phone', '+91 98765 43210' );
		set_theme_mod( 'uttarakhand_tours_contact_email', 'info@example.com' );
		set_theme_mod( 'uttarakhand_tours_contact_address', 'Dehradun, Uttarakhand' );

		$html = $this->render_contact_page();

		$this->assertStringContainsString( '+91 98765 43210', $html );
		$this->assertStringContainsString( 'info@example.com', $html );
		$this->assertStringContainsString( 'Dehradun, Uttarakhand', $html );
	}

	public function test_contact_details_degrade_gracefully_when_none_are_configured() {
		$html = $this->render_contact_page();

		$this->assertStringNotContainsString( 'contact-details', $html );
	}
}
