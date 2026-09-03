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
	<article <?php post_class(); ?>>
		<h1 class="page-title"><?php the_title(); ?></h1>

		<p class="contact-lede">Tell us where you want to go and when. We answer on WhatsApp or over the phone, usually the same day, and put a plan together from there.</p>

		<?php if ( $contact_phone || $contact_email || $contact_address ) : ?>
			<div class="contact-details">
				<?php if ( $contact_phone ) : ?>
					<p class="contact-phone">Phone: <?php echo esc_html( $contact_phone ); ?></p>
				<?php endif; ?>

				<?php if ( $contact_email ) : ?>
					<p class="contact-email">Email: <?php echo esc_html( $contact_email ); ?></p>
				<?php endif; ?>

				<?php if ( $contact_address ) : ?>
					<p class="contact-address"><?php echo esc_html( $contact_address ); ?></p>
				<?php endif; ?>
			</div>
		<?php endif; ?>

		<?php if ( $whatsapp_link ) : ?>
			<a class="whatsapp-contact-cta" href="<?php echo esc_url( $whatsapp_link ); ?>" target="_blank" rel="noopener noreferrer">Chat on WhatsApp</a>
		<?php endif; ?>

		<div class="contact-request-form">
			<h2>Request a custom package</h2>
			<?php
			// Contact Form 7's own form_html() output — trusted plugin markup, not user input.
			echo uttarakhand_tours_render_custom_package_request_form();
			?>
		</div>
	</article>
	<?php
endwhile;

get_footer();
