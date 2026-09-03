<?php
/**
 * Tests for testimonials and the sitewide photo gallery
 * (inc/testimonials-gallery.php, inc/post-types.php).
 */
class Test_Testimonials_Gallery extends WP_UnitTestCase {

	public function test_testimonials_render_with_name_photo_and_quote() {
		$testimonial_id = self::factory()->post->create(
			array(
				'post_type'    => 'testimonial',
				'post_status'  => 'publish',
				'post_title'   => 'Priya Sharma',
				'post_content' => 'The driver knew every mountain road. Best trip of our lives.',
			)
		);

		$photo_id = self::factory()->attachment->create_upload_object(
			DIR_TESTDATA . '/images/canola.jpg',
			$testimonial_id
		);
		set_post_thumbnail( $testimonial_id, $photo_id );

		$html = uttarakhand_tours_render_testimonials();

		$this->assertStringContainsString( 'class="testimonials-list"', $html );
		$this->assertStringContainsString( 'Priya Sharma', $html );
		$this->assertStringContainsString( 'The driver knew every mountain road.', $html );
		$this->assertStringContainsString( wp_get_attachment_image_url( $photo_id, 'thumbnail' ), $html );
	}

	public function test_testimonials_degrade_gracefully_when_none_exist() {
		$html = uttarakhand_tours_render_testimonials();

		$this->assertSame( '', $html );
	}

	public function test_unpublished_testimonials_are_excluded() {
		self::factory()->post->create(
			array(
				'post_type'    => 'testimonial',
				'post_status'  => 'draft',
				'post_title'   => 'Unpublished Reviewer',
				'post_content' => 'Should not appear.',
			)
		);

		$html = uttarakhand_tours_render_testimonials();

		$this->assertSame( '', $html );
	}

	public function test_sitewide_gallery_aggregates_images_from_published_package_galleries() {
		$package_one = self::factory()->post->create(
			array(
				'post_type'   => 'travel_package',
				'post_status' => 'publish',
				'post_title'  => 'Valley of Flowers Trek',
			)
		);
		$image_one = self::factory()->attachment->create_upload_object( DIR_TESTDATA . '/images/canola.jpg', $package_one );
		wp_update_post(
			array(
				'ID'           => $package_one,
				'post_content' => '[gallery ids="' . $image_one . '"]',
			)
		);

		$package_two = self::factory()->post->create(
			array(
				'post_type'   => 'travel_package',
				'post_status' => 'publish',
				'post_title'  => 'Kedarnath Yatra Package',
			)
		);
		$image_two = self::factory()->attachment->create_upload_object( DIR_TESTDATA . '/images/test-image.jpg', $package_two );
		wp_update_post(
			array(
				'ID'           => $package_two,
				'post_content' => '[gallery ids="' . $image_two . '"]',
			)
		);

		$html = uttarakhand_tours_render_sitewide_gallery();

		$this->assertStringContainsString( 'class="sitewide-gallery"', $html );
		$this->assertStringContainsString( wp_get_attachment_image_url( $image_one, 'medium' ), $html );
		$this->assertStringContainsString( wp_get_attachment_image_url( $image_two, 'medium' ), $html );
	}

	public function test_sitewide_gallery_excludes_unpublished_packages() {
		$package_id = self::factory()->post->create(
			array(
				'post_type'   => 'travel_package',
				'post_status' => 'draft',
				'post_title'  => 'Unpublished Package',
			)
		);
		$image_id = self::factory()->attachment->create_upload_object( DIR_TESTDATA . '/images/canola.jpg', $package_id );
		wp_update_post(
			array(
				'ID'           => $package_id,
				'post_content' => '[gallery ids="' . $image_id . '"]',
			)
		);

		$html = uttarakhand_tours_render_sitewide_gallery();

		$this->assertSame( '', $html );
	}

	public function test_sitewide_gallery_degrades_gracefully_when_no_package_has_a_gallery() {
		self::factory()->post->create(
			array(
				'post_type'   => 'travel_package',
				'post_status' => 'publish',
				'post_title'  => 'Nainital Weekend Getaway',
			)
		);

		$html = uttarakhand_tours_render_sitewide_gallery();

		$this->assertSame( '', $html );
	}
}
