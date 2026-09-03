<?php
/**
 * Tests for the `travel_package` post type and its taxonomies.
 */
class Test_Post_Types_Taxonomies extends WP_UnitTestCase {

	public function test_travel_package_post_type_is_registered() {
		$this->assertTrue( post_type_exists( 'travel_package' ) );

		$post_type = get_post_type_object( 'travel_package' );

		$this->assertTrue( $post_type->public );
		$this->assertTrue( $post_type->has_archive );
		$this->assertSame( 'Travel Packages', $post_type->labels->name );
	}

	public function test_package_region_taxonomy_is_registered_on_travel_package() {
		$this->assertTrue( taxonomy_exists( 'package_region' ) );
		$this->assertTrue( is_object_in_taxonomy( 'travel_package', 'package_region' ) );
	}

	public function test_package_theme_taxonomy_is_registered_on_travel_package() {
		$this->assertTrue( taxonomy_exists( 'package_theme' ) );
		$this->assertTrue( is_object_in_taxonomy( 'travel_package', 'package_theme' ) );
	}

	public function test_default_package_region_terms_are_seeded_on_theme_activation() {
		uttarakhand_tours_seed_default_taxonomy_terms();

		foreach ( array( 'Garhwal', 'Kumaon', 'Char Dham', 'Border circuits' ) as $term ) {
			$this->assertNotFalse(
				term_exists( $term, 'package_region' ),
				"Expected package_region term '{$term}' to exist."
			);
		}
	}

	public function test_default_package_theme_terms_are_seeded_on_theme_activation() {
		uttarakhand_tours_seed_default_taxonomy_terms();

		foreach ( array( 'Pilgrimage', 'Trekking', 'Honeymoon', 'Family', 'Weekend' ) as $term ) {
			$this->assertNotFalse(
				term_exists( $term, 'package_theme' ),
				"Expected package_theme term '{$term}' to exist."
			);
		}
	}

	public function test_seeding_default_terms_twice_does_not_error_or_duplicate() {
		uttarakhand_tours_seed_default_taxonomy_terms();
		uttarakhand_tours_seed_default_taxonomy_terms();

		$terms = get_terms(
			array(
				'taxonomy'   => 'package_region',
				'hide_empty' => false,
			)
		);

		$names = wp_list_pluck( $terms, 'name' );

		$this->assertSame( count( $names ), count( array_unique( $names ) ) );
	}

	public function test_a_travel_package_can_be_created_and_assigned_terms() {
		$post_id = self::factory()->post->create(
			array(
				'post_type'   => 'travel_package',
				'post_status' => 'publish',
				'post_title'  => 'Kedarnath Yatra Package',
			)
		);

		wp_set_object_terms( $post_id, 'Char Dham', 'package_region' );
		wp_set_object_terms( $post_id, 'Pilgrimage', 'package_theme' );

		$this->assertSame( 'travel_package', get_post_type( $post_id ) );
		$this->assertTrue( has_term( 'Char Dham', 'package_region', $post_id ) );
		$this->assertTrue( has_term( 'Pilgrimage', 'package_theme', $post_id ) );
	}
}
