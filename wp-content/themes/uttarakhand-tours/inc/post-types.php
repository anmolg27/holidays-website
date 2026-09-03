<?php
/**
 * Custom post type registration.
 */

/**
 * Registers the `travel_package` custom post type.
 *
 * A Travel Package is a curated, bookable-by-inquiry combination of cab
 * transportation, hotel/homestay accommodation, and a guided itinerary.
 * See CONTEXT.md for the full glossary definition.
 */
function uttarakhand_tours_register_travel_package_post_type() {
	$labels = array(
		'name'                  => __( 'Travel Packages', 'uttarakhand-tours' ),
		'singular_name'         => __( 'Travel Package', 'uttarakhand-tours' ),
		'add_new'               => __( 'Add New', 'uttarakhand-tours' ),
		'add_new_item'          => __( 'Add New Travel Package', 'uttarakhand-tours' ),
		'edit_item'             => __( 'Edit Travel Package', 'uttarakhand-tours' ),
		'new_item'              => __( 'New Travel Package', 'uttarakhand-tours' ),
		'view_item'             => __( 'View Travel Package', 'uttarakhand-tours' ),
		'view_items'            => __( 'View Travel Packages', 'uttarakhand-tours' ),
		'search_items'          => __( 'Search Travel Packages', 'uttarakhand-tours' ),
		'not_found'             => __( 'No travel packages found.', 'uttarakhand-tours' ),
		'not_found_in_trash'    => __( 'No travel packages found in Trash.', 'uttarakhand-tours' ),
		'all_items'             => __( 'All Travel Packages', 'uttarakhand-tours' ),
		'archives'              => __( 'Travel Package Archives', 'uttarakhand-tours' ),
		'menu_name'             => __( 'Travel Packages', 'uttarakhand-tours' ),
	);

	register_post_type(
		'travel_package',
		array(
			'labels'       => $labels,
			'public'       => true,
			'has_archive'  => true,
			'show_in_rest' => true,
			'menu_icon'    => 'dashicons-palmtree',
			'supports'     => array( 'title', 'editor', 'thumbnail' ),
			'rewrite'      => array( 'slug' => 'travel-packages' ),
		)
	);
}
add_action( 'init', 'uttarakhand_tours_register_travel_package_post_type' );
