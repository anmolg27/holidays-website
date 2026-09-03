<?php
/**
 * Site-wide WhatsApp click-to-chat number, stored as a single Customizer
 * setting so every WhatsApp link across the theme reads from one place.
 */

/**
 * Registers the single site-wide WhatsApp number as a Customizer setting,
 * so every WhatsApp link in the theme reads from this one value.
 */
function uttarakhand_tours_register_whatsapp_customizer_setting( $wp_customize ) {
	$wp_customize->add_section(
		'uttarakhand_tours_whatsapp',
		array(
			'title' => 'WhatsApp',
		)
	);

	$wp_customize->add_setting(
		'uttarakhand_tours_whatsapp_number',
		array(
			'default'           => '',
			'sanitize_callback' => 'uttarakhand_tours_sanitize_whatsapp_number',
		)
	);

	$wp_customize->add_control(
		'uttarakhand_tours_whatsapp_number',
		array(
			'section'     => 'uttarakhand_tours_whatsapp',
			'label'       => 'WhatsApp Number',
			'description' => 'Used for the floating click-to-chat button and package inquiry links, e.g. "+91 98765 43210".',
			'type'        => 'text',
		)
	);
}
add_action( 'customize_register', 'uttarakhand_tours_register_whatsapp_customizer_setting' );

/**
 * Keeps only digits, spaces, and "+" — WhatsApp deep links strip down to
 * digits anyway (see uttarakhand_tours_get_whatsapp_link()), so this just
 * preserves a readable Customizer display value like "+91 98765 43210".
 */
function uttarakhand_tours_sanitize_whatsapp_number( $value ) {
	return preg_replace( '/[^\d+ ]/', '', $value );
}

function uttarakhand_tours_get_whatsapp_number() {
	return get_theme_mod( 'uttarakhand_tours_whatsapp_number', '' );
}

/**
 * Builds a wa.me deep link for the site-wide WhatsApp number, pre-filling
 * the chat with $message. Returns an empty string when no number is
 * configured, so callers can skip rendering their WhatsApp link entirely.
 */
function uttarakhand_tours_get_whatsapp_link( $message = '' ) {
	$digits = preg_replace( '/\D/', '', uttarakhand_tours_get_whatsapp_number() );

	if ( ! $digits ) {
		return '';
	}

	return 'https://wa.me/' . $digits . '?text=' . rawurlencode( $message );
}
