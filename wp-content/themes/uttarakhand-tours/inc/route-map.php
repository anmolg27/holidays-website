<?php
/**
 * Interactive Route Stops map: Leaflet + OpenStreetMap tiles (no API key,
 * no billing account), plotting a package's Route Stops as ordered markers
 * connected by a straight waypoint line — not a road-following route.
 */

/**
 * Parses the `route_stops` ACF textarea ("Place Name | latitude, longitude",
 * one stop per line) into ordered marker data. Malformed lines (missing the
 * "|" separator, missing a name, or non-numeric coordinates) are skipped
 * rather than breaking the whole map.
 */
function uttarakhand_tours_parse_route_stops( $raw_route_stops ) {
	if ( ! $raw_route_stops ) {
		return array();
	}

	$stops = array();

	foreach ( preg_split( '/\r\n|\r|\n/', $raw_route_stops ) as $line ) {
		$line = trim( $line );

		if ( '' === $line ) {
			continue;
		}

		$parts = explode( '|', $line, 2 );

		if ( 2 !== count( $parts ) ) {
			continue;
		}

		$name = trim( $parts[0] );

		if ( '' === $name ) {
			continue;
		}

		$coordinates = explode( ',', $parts[1], 2 );

		if ( 2 !== count( $coordinates ) ) {
			continue;
		}

		$lat = trim( $coordinates[0] );
		$lng = trim( $coordinates[1] );

		if ( ! is_numeric( $lat ) || ! is_numeric( $lng ) ) {
			continue;
		}

		$stops[] = array(
			'name' => $name,
			'lat'  => (float) $lat,
			'lng'  => (float) $lng,
		);
	}

	return $stops;
}

/**
 * Renders the map container with its marker data as a data attribute for
 * assets/js/route-map.js to read, or an empty string when there are no
 * (valid) Route Stops — no broken empty map on the page.
 */
function uttarakhand_tours_render_route_map( $route_stops ) {
	if ( empty( $route_stops ) ) {
		return '';
	}

	return sprintf(
		'<div id="package-route-map" class="package-route-map" data-route-stops="%s"></div>',
		esc_attr( wp_json_encode( $route_stops ) )
	);
}

/**
 * Enqueues Leaflet and the theme's map script only on single Travel Package
 * pages, deferred so map loading never blocks the rest of the page.
 */
function uttarakhand_tours_enqueue_route_map_assets() {
	if ( ! is_singular( 'travel_package' ) ) {
		return;
	}

	wp_enqueue_style(
		'leaflet',
		'https://unpkg.com/leaflet@1.9.4/dist/leaflet.css',
		array(),
		'1.9.4'
	);

	wp_enqueue_script(
		'leaflet',
		'https://unpkg.com/leaflet@1.9.4/dist/leaflet.js',
		array(),
		'1.9.4',
		array(
			'strategy'  => 'defer',
			'in_footer' => true,
		)
	);

	wp_enqueue_script(
		'uttarakhand-tours-route-map',
		get_stylesheet_directory_uri() . '/assets/js/route-map.js',
		array( 'leaflet' ),
		wp_get_theme()->get( 'Version' ),
		array(
			'strategy'  => 'defer',
			'in_footer' => true,
		)
	);
}
add_action( 'wp_enqueue_scripts', 'uttarakhand_tours_enqueue_route_map_assets' );
