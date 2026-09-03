<?php
/**
 * Taxonomy registration for the `travel_package` post type.
 */

/**
 * Registers the `package_region` and `package_theme` taxonomies.
 *
 * Both are left open for the client to add new terms via the standard
 * wp-admin taxonomy screens — the terms seeded in
 * uttarakhand_tours_seed_default_taxonomy_terms() are a starting set, not
 * a fixed list.
 */
function uttarakhand_tours_register_taxonomies() {
	register_taxonomy(
		'package_region',
		'travel_package',
		array(
			'labels'            => array(
				'name'          => __( 'Package Regions', 'uttarakhand-tours' ),
				'singular_name' => __( 'Package Region', 'uttarakhand-tours' ),
				'search_items'  => __( 'Search Package Regions', 'uttarakhand-tours' ),
				'all_items'     => __( 'All Package Regions', 'uttarakhand-tours' ),
				'edit_item'     => __( 'Edit Package Region', 'uttarakhand-tours' ),
				'update_item'   => __( 'Update Package Region', 'uttarakhand-tours' ),
				'add_new_item'  => __( 'Add New Package Region', 'uttarakhand-tours' ),
				'new_item_name' => __( 'New Package Region Name', 'uttarakhand-tours' ),
				'menu_name'     => __( 'Regions', 'uttarakhand-tours' ),
			),
			'hierarchical'      => true,
			'public'            => true,
			'show_admin_column' => true,
			'show_in_rest'      => true,
			'rewrite'           => array( 'slug' => 'package-region' ),
		)
	);

	register_taxonomy(
		'package_theme',
		'travel_package',
		array(
			'labels'            => array(
				'name'          => __( 'Package Themes', 'uttarakhand-tours' ),
				'singular_name' => __( 'Package Theme', 'uttarakhand-tours' ),
				'search_items'  => __( 'Search Package Themes', 'uttarakhand-tours' ),
				'all_items'     => __( 'All Package Themes', 'uttarakhand-tours' ),
				'edit_item'     => __( 'Edit Package Theme', 'uttarakhand-tours' ),
				'update_item'   => __( 'Update Package Theme', 'uttarakhand-tours' ),
				'add_new_item'  => __( 'Add New Package Theme', 'uttarakhand-tours' ),
				'new_item_name' => __( 'New Package Theme Name', 'uttarakhand-tours' ),
				'menu_name'     => __( 'Themes', 'uttarakhand-tours' ),
			),
			'hierarchical'      => false,
			'public'            => true,
			'show_admin_column' => true,
			'show_in_rest'      => true,
			'rewrite'           => array( 'slug' => 'package-theme' ),
		)
	);
}
add_action( 'init', 'uttarakhand_tours_register_taxonomies', 0 );

/**
 * Seeds the initial `package_region` and `package_theme` terms on theme
 * activation. Idempotent: skips any term that already exists, so
 * re-activating the theme never errors or duplicates terms.
 */
function uttarakhand_tours_seed_default_taxonomy_terms() {
	$default_terms = array(
		'package_region' => array( 'Garhwal', 'Kumaon', 'Char Dham', 'Border circuits' ),
		'package_theme'  => array( 'Pilgrimage', 'Trekking', 'Honeymoon', 'Family', 'Weekend' ),
	);

	foreach ( $default_terms as $taxonomy => $terms ) {
		foreach ( $terms as $term ) {
			if ( ! term_exists( $term, $taxonomy ) ) {
				wp_insert_term( $term, $taxonomy );
			}
		}
	}
}
add_action( 'after_switch_theme', 'uttarakhand_tours_seed_default_taxonomy_terms' );
