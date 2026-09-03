<?php
/**
 * PHPUnit bootstrap: boots the real WordPress core test suite (via the
 * wp-phpunit/wp-phpunit composer package), loads ACF (free) as it would
 * run as an active plugin, and switches to this theme before WordPress
 * loads, so `travel_package`, its taxonomies, and its ACF fields are
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
 * Loads the ACF (free) plugin, the same way it would load if activated
 * from wp-content/plugins on a live site.
 */
function uttarakhand_tours_manually_load_acf() {
	require_once dirname( __DIR__, 2 ) . '/vendor/wp-plugins/advanced-custom-fields/acf.php';
}
tests_add_filter( 'muplugins_loaded', 'uttarakhand_tours_manually_load_acf' );

/**
 * Switches the active theme to Uttarakhand Tours for the duration of the
 * test run, before WordPress finishes loading.
 */
function uttarakhand_tours_manually_load_theme() {
	switch_theme( 'uttarakhand-tours' );
}
tests_add_filter( 'muplugins_loaded', 'uttarakhand_tours_manually_load_theme' );

require $_tests_dir . '/includes/bootstrap.php';
