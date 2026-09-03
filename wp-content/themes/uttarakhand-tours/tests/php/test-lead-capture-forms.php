<?php
/**
 * Tests for the Contact Form 7 lead-capture forms: the per-package
 * inquiry form and the standalone Custom Package Request form.
 */
class Test_Lead_Capture_Forms extends WP_UnitTestCase {

	public function set_up() {
		parent::set_up();
		uttarakhand_tours_seed_lead_capture_forms();
	}

	public function test_contact_form_7_is_loaded() {
		$this->assertTrue( class_exists( 'WPCF7_ContactForm' ) );
	}

	public function test_package_inquiry_form_is_created_with_required_fields() {
		$form = wpcf7_get_contact_form_by_title( 'Package Inquiry' );
		$this->assertNotNull( $form );

		$template = $form->prop( 'form' );

		$this->assertStringContainsString( '[date* travel-date]', $template );
		$this->assertStringContainsString( '[number* passenger-count', $template );
		$this->assertStringContainsString( '[select* preferred-vehicle', $template );
		$this->assertStringContainsString( '[hidden package-id default:shortcode_attr]', $template );
		$this->assertStringContainsString( '[hidden package-title default:shortcode_attr]', $template );
		$this->assertStringNotContainsStringIgnoringCase( 'price', $template );
	}

	public function test_custom_package_request_form_is_created_with_required_fields() {
		$form = wpcf7_get_contact_form_by_title( 'Custom Package Request' );
		$this->assertNotNull( $form );

		$template = $form->prop( 'form' );

		$this->assertStringContainsString( '[select* region', $template );
		$this->assertStringContainsString( '[date* travel-start-date]', $template );
		$this->assertStringContainsString( '[text* travel-duration', $template );
		$this->assertStringContainsString( '[number* passenger-count', $template );
		$this->assertStringContainsString( '[select* vehicle-preference', $template );
		$this->assertStringContainsString( '[select* accommodation-tier', $template );
		$this->assertStringContainsString( '[textarea notes]', $template );
		$this->assertStringNotContainsStringIgnoringCase( 'price', $template );
	}

	public function test_seeding_forms_twice_does_not_duplicate() {
		uttarakhand_tours_seed_lead_capture_forms();

		$inquiry_forms = WPCF7_ContactForm::find( array( 'title' => 'Package Inquiry' ) );
		$request_forms = WPCF7_ContactForm::find( array( 'title' => 'Custom Package Request' ) );

		$this->assertCount( 1, $inquiry_forms );
		$this->assertCount( 1, $request_forms );
	}

	public function test_package_inquiry_form_renders_with_all_fields_and_the_embedding_packages_reference() {
		$post_id = self::factory()->post->create(
			array(
				'post_type'   => 'travel_package',
				'post_status' => 'publish',
				'post_title'  => 'Valley of Flowers Trek',
			)
		);

		$html = uttarakhand_tours_render_package_inquiry_form( $post_id, get_the_title( $post_id ) );

		$this->assertStringContainsString( 'name="travel-date"', $html );
		$this->assertStringContainsString( 'name="passenger-count"', $html );
		$this->assertStringContainsString( 'name="preferred-vehicle"', $html );

		preg_match( '#<input[^>]*name="package-id"[^>]*/>#', $html, $package_id_input );
		preg_match( '#<input[^>]*name="package-title"[^>]*/>#', $html, $package_title_input );

		$this->assertStringContainsString( 'value="' . $post_id . '"', $package_id_input[0] ?? '' );
		$this->assertStringContainsString( 'value="Valley of Flowers Trek"', $package_title_input[0] ?? '' );

		$this->assertStringNotContainsStringIgnoringCase( 'price', $html );
	}

	public function test_custom_package_request_form_renders_with_all_fields_and_current_region_terms() {
		uttarakhand_tours_seed_default_taxonomy_terms();

		$html = uttarakhand_tours_render_custom_package_request_form();

		$this->assertStringContainsString( 'name="region"', $html );
		$this->assertStringContainsString( 'name="travel-start-date"', $html );
		$this->assertStringContainsString( 'name="travel-duration"', $html );
		$this->assertStringContainsString( 'name="passenger-count"', $html );
		$this->assertStringContainsString( 'name="vehicle-preference"', $html );
		$this->assertStringContainsString( 'name="accommodation-tier"', $html );
		$this->assertStringContainsString( 'name="notes"', $html );

		foreach ( array( 'Garhwal', 'Kumaon', 'Char Dham', 'Border circuits' ) as $region ) {
			$this->assertStringContainsString( '<option value="' . $region . '">' . $region . '</option>', $html );
		}

		$this->assertStringNotContainsStringIgnoringCase( 'price', $html );
	}
}
