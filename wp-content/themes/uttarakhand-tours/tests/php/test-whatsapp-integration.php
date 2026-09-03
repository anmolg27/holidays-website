<?php
/**
 * Tests for the site-wide WhatsApp integration (number setting + deep links).
 */
class Test_Whatsapp_Integration extends WP_UnitTestCase {

	public function tearDown(): void {
		remove_theme_mod( 'uttarakhand_tours_whatsapp_number' );
		parent::tearDown();
	}

	private function render_single_travel_package( $post_id ) {
		$this->go_to( get_permalink( $post_id ) );

		ob_start();
		include get_stylesheet_directory() . '/single-travel_package.php';
		return ob_get_clean();
	}

	public function test_floating_button_and_inquire_cta_link_to_the_configured_number_with_the_package_title() {
		set_theme_mod( 'uttarakhand_tours_whatsapp_number', '+91 98765 43210' );

		$post_id = self::factory()->post->create(
			array(
				'post_type'   => 'travel_package',
				'post_status' => 'publish',
				'post_title'  => 'Valley of Flowers Trek',
			)
		);

		$html = $this->render_single_travel_package( $post_id );

		$this->assertMatchesRegularExpression(
			'#<a[^>]+class="whatsapp-floating-button"[^>]+href="([^"]+)"#',
			$html
		);
		preg_match( '#<a[^>]+class="whatsapp-floating-button"[^>]+href="([^"]+)"#', $html, $floating_matches );

		$this->assertMatchesRegularExpression(
			'#<a[^>]+class="whatsapp-inquire-cta"[^>]+href="([^"]+)"#',
			$html
		);
		preg_match( '#<a[^>]+class="whatsapp-inquire-cta"[^>]+href="([^"]+)"#', $html, $cta_matches );

		$floating_href = html_entity_decode( $floating_matches[1] );
		$cta_href      = html_entity_decode( $cta_matches[1] );

		$this->assertStringContainsString( 'https://wa.me/919876543210', $floating_href );
		$this->assertStringContainsString( rawurlencode( 'Valley of Flowers Trek' ), $floating_href );

		$this->assertStringContainsString( 'https://wa.me/919876543210', $cta_href );
		$this->assertStringContainsString( rawurlencode( 'Valley of Flowers Trek' ), $cta_href );
	}

	public function test_whatsapp_links_are_absent_when_no_number_is_configured() {
		$post_id = self::factory()->post->create(
			array(
				'post_type'   => 'travel_package',
				'post_status' => 'publish',
				'post_title'  => 'Valley of Flowers Trek',
			)
		);

		$html = $this->render_single_travel_package( $post_id );

		$this->assertStringNotContainsString( 'whatsapp-floating-button', $html );
		$this->assertStringNotContainsString( 'whatsapp-inquire-cta', $html );
	}
}
