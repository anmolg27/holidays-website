<?php
/**
 * Tests for the Mountain Advisory callout on the single-travel_package.php
 * template.
 */
class Test_Mountain_Advisory extends WP_UnitTestCase {

	private function render_single_travel_package( $post_id ) {
		$this->go_to( get_permalink( $post_id ) );

		ob_start();
		include get_stylesheet_directory() . '/single-travel_package.php';
		return ob_get_clean();
	}

	public function test_advisory_content_renders_in_a_distinct_callout_when_present() {
		$post_id = self::factory()->post->create(
			array(
				'post_type'   => 'travel_package',
				'post_status' => 'publish',
				'post_title'  => 'Kedarnath Yatra Package',
			)
		);

		update_field(
			'mountain_advisory_content',
			'<p>Road closed near Sonprayag after 6pm. Carry raincoats during monsoon. Char Dham permit required.</p>',
			$post_id
		);

		$html = $this->render_single_travel_package( $post_id );

		$this->assertStringContainsString( 'class="package-mountain-advisory"', $html );
		$this->assertStringContainsString( 'Mountain Advisory', $html );
		$this->assertStringContainsString( 'Road closed near Sonprayag after 6pm.', $html );
		$this->assertStringContainsString( 'Carry raincoats during monsoon.', $html );
		$this->assertStringContainsString( 'Char Dham permit required.', $html );
	}

	public function test_callout_is_omitted_when_no_advisory_content_is_set() {
		$post_id = self::factory()->post->create(
			array(
				'post_type'   => 'travel_package',
				'post_status' => 'publish',
				'post_title'  => 'Nainital Weekend Getaway',
			)
		);

		$html = $this->render_single_travel_package( $post_id );

		$this->assertStringNotContainsString( 'package-mountain-advisory', $html );
		$this->assertStringNotContainsString( 'Mountain Advisory', $html );
	}
}
