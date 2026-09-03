<?php
/**
 * PHPUnit bootstrap: boots the real WordPress core test suite (via the
 * wp-phpunit/wp-phpunit composer package) and switches to this theme
 * before WordPress loads, so `travel_package` and its taxonomies are
 * registered exactly as they would be on a live site.
 */

$_tests_dir = getenv( 'WP_TESTS_DIR' );

if ( ! $_tests_dir ) {
	$_tests_dir = getenv( 'WP_PHPUNIT__DIR' );
}

if ( ! $_tests_dir ) {
	$_tests_dir = dirname( __DIR__, 2 ) . '/vendor/wp-phpunit/wp-phpunit';
}

require_once $_tests_dir . '/includes/functions.php';

/**
 * Switches the active theme to Uttarakhand Tours for the duration of the
 * test run, before WordPress finishes loading.
 */
function uttarakhand_tours_manually_load_theme() {
	switch_theme( 'uttarakhand-tours' );
}
tests_add_filter( 'muplugins_loaded', 'uttarakhand_tours_manually_load_theme' );

require $_tests_dir . '/includes/bootstrap.php';
