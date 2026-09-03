<?php
/**
 * Contact page: basic company contact details, seeded as a Customizer
 * section like the WhatsApp number (see inc/whatsapp.php), plus the
 * "Contact" Page itself (rendered by page-contact.php), seeded like the
 * About Us & Fleet/Hotels page (see inc/about-fleet-page.php).
 */

const UTTARAKHAND_TOURS_CONTACT_PAGE_SLUG = 'contact';

/**
 * Registers the site-wide phone/email/address Customizer settings — all
 * optional, since ticket 11 asks for these "as available".
 */
function uttarakhand_tours_register_contact_details_customizer_settings( $wp_customize ) {
	$wp_customize->add_section(
		'uttarakhand_tours_contact_details',
		array(
			'title' => 'Contact Details',
		)
	);

	$wp_customize->add_setting(
		'uttarakhand_tours_contact_phone',
		array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'uttarakhand_tours_contact_phone',
		array(
			'section' => 'uttarakhand_tours_contact_details',
			'label'   => 'Phone',
			'type'    => 'text',
		)
	);

	$wp_customize->add_setting(
		'uttarakhand_tours_contact_email',
		array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_email',
		)
	);
	$wp_customize->add_control(
		'uttarakhand_tours_contact_email',
		array(
			'section' => 'uttarakhand_tours_contact_details',
			'label'   => 'Email',
			'type'    => 'email',
		)
	);

	$wp_customize->add_setting(
		'uttarakhand_tours_contact_address',
		array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_textarea_field',
		)
	);
	$wp_customize->add_control(
		'uttarakhand_tours_contact_address',
		array(
			'section' => 'uttarakhand_tours_contact_details',
			'label'   => 'Address',
			'type'    => 'textarea',
		)
	);
}
add_action( 'customize_register', 'uttarakhand_tours_register_contact_details_customizer_settings' );

function uttarakhand_tours_get_contact_phone() {
	return get_theme_mod( 'uttarakhand_tours_contact_phone', '' );
}

function uttarakhand_tours_get_contact_email() {
	return get_theme_mod( 'uttarakhand_tours_contact_email', '' );
}

function uttarakhand_tours_get_contact_address() {
	return get_theme_mod( 'uttarakhand_tours_contact_address', '' );
}

/**
 * Creates the "Contact" page on theme activation. Idempotent: skips
 * creation if a page with the same slug already exists, so re-activating
 * the theme never duplicates the page.
 */
function uttarakhand_tours_seed_contact_page() {
	if ( get_page_by_path( UTTARAKHAND_TOURS_CONTACT_PAGE_SLUG ) ) {
		return;
	}

	wp_insert_post(
		array(
			'post_type'   => 'page',
			'post_status' => 'publish',
			'post_title'  => 'Contact',
			'post_name'   => UTTARAKHAND_TOURS_CONTACT_PAGE_SLUG,
		)
	);
}
add_action( 'after_switch_theme', 'uttarakhand_tours_seed_contact_page' );
