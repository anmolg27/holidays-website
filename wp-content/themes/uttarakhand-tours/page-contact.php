<?php
/**
 * Contact page template (overrides page.php for the "contact" slug, per
 * WordPress's template hierarchy).
 *
 * Combines the standalone Custom Package Request form (ticket 06), the
 * site-wide WhatsApp click-to-chat (ticket 05), and basic company contact
 * details, giving visitors one clear place to reach the company through
 * either channel.
 */

get_header();

while ( have_posts() ) :
	the_post();

	$contact_phone   = uttarakhand_tours_get_contact_phone();
	$contact_email   = uttarakhand_tours_get_contact_email();
	$contact_address = uttarakhand_tours_get_contact_address();
	$whatsapp_link   = uttarakhand_tours_get_whatsapp_link( "Hi, I'd like to know more about your travel packages." );
	?>
	<?php
	/*
	 * The article carries its own class rather than relying on a
	 * `page-template-page-contact` body class: WordPress only emits that class
	 * for templates assigned through Page Attributes, and this template is
	 * picked by the template hierarchy from the "contact" slug instead.
	 */
	?>
	<article <?php post_class( 'contact-page' ); ?>>
		<header class="contact-page-header">
			<h1 class="page-title"><?php the_title(); ?></h1>
			<p>Tell us where you want to go and how you prefer to travel. We will follow up personally to shape the details.</p>
		</header>

		<?php if ( $contact_phone || $contact_email || $contact_address || $whatsapp_link ) : ?>
			<section class="contact-channels" aria-label="<?php esc_attr_e( 'Contact details', 'uttarakhand-tours' ); ?>">
				<?php if ( $contact_phone || $contact_email || $contact_address ) : ?>
					<div class="contact-details">
						<?php if ( $contact_phone ) : ?>
							<div class="contact-detail contact-phone">
								<span class="contact-detail-label">Phone</span>
								<p class="contact-detail-value"><?php echo esc_html( $contact_phone ); ?></p>
							</div>
						<?php endif; ?>

						<?php if ( $contact_email ) : ?>
							<div class="contact-detail contact-email">
								<span class="contact-detail-label">Email</span>
								<p class="contact-detail-value"><?php echo esc_html( $contact_email ); ?></p>
							</div>
						<?php endif; ?>

						<?php if ( $contact_address ) : ?>
							<div class="contact-detail contact-address">
								<span class="contact-detail-label">Visit</span>
								<p class="contact-detail-value"><?php echo esc_html( $contact_address ); ?></p>
							</div>
						<?php endif; ?>
					</div>
				<?php endif; ?>

				<?php if ( $whatsapp_link ) : ?>
					<a class="whatsapp-contact-cta" href="<?php echo esc_url( $whatsapp_link ); ?>" target="_blank" rel="noopener noreferrer">Chat on WhatsApp</a>
				<?php endif; ?>
			</section>
		<?php endif; ?>

		<section class="contact-request-form">
			<h2>Request a Custom Package</h2>
			<?php
			// Contact Form 7's own form_html() output — trusted plugin markup, not user input.
			echo uttarakhand_tours_render_custom_package_request_form();
			?>
		</section>
	</article>
	<?php
endwhile;

get_footer();
