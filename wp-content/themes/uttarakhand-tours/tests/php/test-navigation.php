<?php
/**
 * Tests for the primary site navigation (inc/navigation.php).
 */
class Test_Navigation extends WP_UnitTestCase {

	public function set_up() {
		parent::set_up();
		uttarakhand_tours_seed_about_fleet_page();
		uttarakhand_tours_seed_contact_page();
	}

	public function test_primary_nav_menu_location_is_registered() {
		$this->assertContains( 'primary', array_keys( get_registered_nav_menus() ) );
	}

	public function test_seeding_creates_a_menu_assigned_to_the_primary_location_with_expected_items() {
		uttarakhand_tours_seed_primary_nav_menu();

		$this->assertTrue( has_nav_menu( 'primary' ) );

		$locations = get_nav_menu_locations();
		$menu      = wp_get_nav_menu_object( $locations['primary'] );
		$items     = wp_get_nav_menu_items( $menu );

		$titles = wp_list_pluck( $items, 'title' );

		$this->assertContains( 'Home', $titles );
		$this->assertContains( 'Packages', $titles );
		$this->assertContains( 'About Us', $titles );
		$this->assertContains( 'Contact', $titles );
	}

	public function test_seeding_is_idempotent() {
		uttarakhand_tours_seed_primary_nav_menu();
		uttarakhand_tours_seed_primary_nav_menu();

		$menus = wp_get_nav_menus();

		$this->assertCount( 1, $menus );
	}

	public function test_primary_nav_renders_with_all_expected_links_when_a_menu_is_assigned() {
		uttarakhand_tours_seed_primary_nav_menu();

		$html = uttarakhand_tours_render_primary_nav();

		$this->assertStringContainsString( 'class="primary-nav"', $html );
		$this->assertStringContainsString( 'Home', $html );
		$this->assertStringContainsString( 'Packages', $html );
		$this->assertStringContainsString( 'Contact', $html );
	}

	public function test_primary_nav_degrades_gracefully_when_no_menu_is_assigned() {
		// The menu is seeded once, permanently, at bootstrap (like the About
		// and Contact pages) — simulate a client unassigning it in
		// Appearance > Menus, a real state this function must still handle.
		$locations = get_theme_mod( 'nav_menu_locations', array() );
		unset( $locations['primary'] );
		set_theme_mod( 'nav_menu_locations', $locations );

		$html = uttarakhand_tours_render_primary_nav();

		$this->assertSame( '', $html );
	}
}
