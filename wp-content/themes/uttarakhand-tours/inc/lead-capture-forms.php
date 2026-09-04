<?php
/**
 * Contact Form 7 lead-capture forms: a per-package inquiry form and a
 * standalone Custom Package Request form. Both forms are created in code
 * (like the ACF field group) so they travel with the theme rather than
 * needing to be rebuilt by hand in every environment.
 *
 * Neither form has a price field or mail-tag: submissions are inquiries,
 * never bookings or quotes.
 */

/**
 * Vehicle option and hotel tier choices are duplicated here (rather than
 * read from inc/acf-fields.php) because ACF field choices are keyed by
 * machine slug (e.g. "suv_innova") for storage, while these are CF7 select
 * option labels submitted and emailed as plain text.
 */
const UTTARAKHAND_TOURS_VEHICLE_CHOICES      = array( 'Sedan', 'SUV/Innova', 'Tempo Traveller' );
const UTTARAKHAND_TOURS_ACCOMMODATION_TIERS  = array( 'Standard', 'Deluxe', 'Luxury' );

/**
 * Creates the "Package Inquiry" and "Custom Package Request" Contact Form 7
 * forms on theme activation. Idempotent: skips creation if a form with the
 * same title already exists, so re-activating the theme never duplicates
 * forms or discards edits a client has made to them.
 */
function uttarakhand_tours_seed_lead_capture_forms() {
	if ( ! class_exists( 'WPCF7_ContactForm' ) ) {
		return;
	}

	if ( ! wpcf7_get_contact_form_by_title( 'Package Inquiry' ) ) {
		$form = WPCF7_ContactForm::get_template( array( 'title' => 'Package Inquiry' ) );
		$form->set_properties(
			array(
				'form' => uttarakhand_tours_package_inquiry_form_template(),
				'mail' => array(
					'subject'            => '[_site_title] Package Inquiry: [package-title]',
					'sender'             => '[_site_title] <wordpress@[_site_url]>',
					'body'               => "New package inquiry received.\n\nFrom: [your-name]\nPhone / WhatsApp: [your-phone]\nEmail: [your-email]\n\nPackage: [package-title] (ID: [package-id])\nTravel Date: [travel-date]\nPassengers: [passenger-count]\nPreferred Vehicle: [preferred-vehicle]",
					'recipient'          => '[_site_admin_email]',
					'additional_headers' => '',
					'attachments'        => '',
					'use_html'           => 0,
					'exclude_blank'      => 0,
				),
			)
		);
		$form->save();
	}

	if ( ! wpcf7_get_contact_form_by_title( 'Custom Package Request' ) ) {
		$form = WPCF7_ContactForm::get_template( array( 'title' => 'Custom Package Request' ) );
		$form->set_properties(
			array(
				'form' => uttarakhand_tours_custom_package_request_form_template(),
				'mail' => array(
					'subject'            => '[_site_title] Custom Package Request',
					'sender'             => '[_site_title] <wordpress@[_site_url]>',
					'body'               => "New custom package request received.\n\nFrom: [your-name]\nPhone / WhatsApp: [your-phone]\nEmail: [your-email]\n\nRegion: [region]\nTravel Start Date: [travel-start-date]\nDuration: [travel-duration]\nPassengers: [passenger-count]\nVehicle Preference: [vehicle-preference]\nAccommodation Tier: [accommodation-tier]\nNotes:\n[notes]",
					'recipient'          => '[_site_admin_email]',
					'additional_headers' => '',
					'attachments'        => '',
					'use_html'           => 0,
					'exclude_blank'      => 0,
				),
			)
		);
		$form->save();
	}
}
add_action( 'after_switch_theme', 'uttarakhand_tours_seed_lead_capture_forms' );

/**
 * The `package-id`/`package-title` hidden fields read their value from the
 * form's shortcode_atts via CF7's `default:shortcode_attr` option, which
 * uttarakhand_tours_render_package_inquiry_form() supplies per package.
 */
function uttarakhand_tours_package_inquiry_form_template() {
	return sprintf(
		'[hidden package-id default:shortcode_attr]
[hidden package-title default:shortcode_attr]

<label>Your Name
    [text* your-name] </label>

<label>Mobile / WhatsApp Number
    [tel* your-phone] </label>

<label>Email (optional)
    [email your-email] </label>

<label>Travel Date
    [date* travel-date] </label>

<label>Passenger Count
    [number* passenger-count min:1] </label>

<label>Preferred Vehicle
    [select* preferred-vehicle "%s"] </label>

[submit "Send Inquiry"]',
		implode( '" "', UTTARAKHAND_TOURS_VEHICLE_CHOICES )
	);
}

/**
 * The region options here are a fallback for the form's initial save;
 * uttarakhand_tours_populate_region_select_options() re-populates them
 * from live `package_region` terms on every render.
 */
function uttarakhand_tours_custom_package_request_form_template() {
	return sprintf(
		'<label>Your Name
    [text* your-name] </label>

<label>Mobile / WhatsApp Number
    [tel* your-phone] </label>

<label>Email (optional)
    [email your-email] </label>

<label>Region
    [select* region "%1$s"] </label>

<label>Travel Start Date
    [date* travel-start-date] </label>

<label>Duration
    [text* travel-duration placeholder "e.g. 5 Days / 4 Nights"] </label>

<label>Passenger Count
    [number* passenger-count min:1] </label>

<label>Vehicle Preference
    [select* vehicle-preference "%2$s"] </label>

<label>Accommodation Tier
    [select* accommodation-tier "%3$s"] </label>

<label>Notes
    [textarea notes] </label>

[submit "Send Request"]',
		implode( '" "', uttarakhand_tours_get_package_region_names() ),
		implode( '" "', UTTARAKHAND_TOURS_VEHICLE_CHOICES ),
		implode( '" "', UTTARAKHAND_TOURS_ACCOMMODATION_TIERS )
	);
}

/**
 * Reads current `package_region` term names, for both the form's initial
 * options at seed time and the live re-population below.
 */
function uttarakhand_tours_get_package_region_names() {
	$terms = get_terms(
		array(
			'taxonomy'   => 'package_region',
			'hide_empty' => false,
		)
	);

	if ( is_wp_error( $terms ) || empty( $terms ) ) {
		return array();
	}

	return wp_list_pluck( $terms, 'name' );
}

/**
 * Keeps the Custom Package Request form's region options in sync with
 * `package_region` terms at render time, so adding/renaming/removing a
 * region term doesn't require regenerating the CF7 form.
 */
function uttarakhand_tours_populate_region_select_options( $scanned_tag ) {
	if ( 'select' !== $scanned_tag['basetype'] || 'region' !== $scanned_tag['name'] ) {
		return $scanned_tag;
	}

	$region_names = uttarakhand_tours_get_package_region_names();

	if ( empty( $region_names ) ) {
		return $scanned_tag;
	}

	$scanned_tag['raw_values'] = $region_names;
	$scanned_tag['values']     = $region_names;
	$scanned_tag['labels']     = $region_names;

	return $scanned_tag;
}
add_filter( 'wpcf7_form_tag', 'uttarakhand_tours_populate_region_select_options' );

/**
 * Renders the Package Inquiry form for a specific package, pre-filling the
 * hidden package-id/package-title fields via CF7's shortcode_attr default.
 */
function uttarakhand_tours_render_package_inquiry_form( $post_id, $package_title ) {
	$form = wpcf7_get_contact_form_by_title( 'Package Inquiry' );

	if ( ! $form ) {
		return '';
	}

	return $form->form_html(
		array(
			'package-id'    => $post_id,
			'package-title' => $package_title,
		)
	);
}

/**
 * Renders the standalone Custom Package Request form.
 */
function uttarakhand_tours_render_custom_package_request_form() {
	$form = wpcf7_get_contact_form_by_title( 'Custom Package Request' );

	if ( ! $form ) {
		return '';
	}

	return $form->form_html();
}
