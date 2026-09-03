<?php
/**
 * Site footer, shared by every template.
 *
 * Class names here deliberately avoid the `contact-details` /
 * `whatsapp-contact-cta` hooks the Contact page owns, so the footer's own
 * reach block never stands in for the Contact page's.
 */

$uttarakhand_tours_footer_phone   = uttarakhand_tours_get_contact_phone();
$uttarakhand_tours_footer_email   = uttarakhand_tours_get_contact_email();
$uttarakhand_tours_footer_address = uttarakhand_tours_get_contact_address();
?>
</main>

<footer class="site-footer">
	<div class="site-footer-inner">
		<div class="site-footer-brand">
			<p class="site-footer-name"><?php bloginfo( 'name' ); ?></p>
			<p><?php esc_html_e( 'We arrange the cab, the stay and the day-by-day plan across Garhwal, Kumaon and the Char Dham routes — driven by a local team that knows these roads in every season.', 'uttarakhand-tours' ); ?></p>
		</div>

		<div class="site-footer-columns">
			<nav class="site-footer-nav" aria-label="<?php esc_attr_e( 'Footer', 'uttarakhand-tours' ); ?>">
				<h2 class="site-footer-heading"><?php esc_html_e( 'Explore', 'uttarakhand-tours' ); ?></h2>
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'footer',
						'container'      => false,
						'menu_class'     => 'site-footer-nav-list',
						'depth'          => 1,
						'fallback_cb'    => 'uttarakhand_tours_default_footer_menu',
					)
				);
				?>
			</nav>

			<?php if ( $uttarakhand_tours_footer_phone || $uttarakhand_tours_footer_email || $uttarakhand_tours_footer_address ) : ?>
				<div class="site-footer-reach">
					<h2 class="site-footer-heading"><?php esc_html_e( 'Reach us', 'uttarakhand-tours' ); ?></h2>
					<ul class="site-footer-reach-list">
						<?php if ( $uttarakhand_tours_footer_phone ) : ?>
							<li><a class="site-footer-phone" href="tel:<?php echo esc_attr( preg_replace( '/[^\d+]/', '', $uttarakhand_tours_footer_phone ) ); ?>"><?php echo esc_html( $uttarakhand_tours_footer_phone ); ?></a></li>
						<?php endif; ?>

						<?php if ( $uttarakhand_tours_footer_email ) : ?>
							<li><a class="site-footer-email" href="mailto:<?php echo esc_attr( $uttarakhand_tours_footer_email ); ?>"><?php echo esc_html( $uttarakhand_tours_footer_email ); ?></a></li>
						<?php endif; ?>

						<?php if ( $uttarakhand_tours_footer_address ) : ?>
							<li class="site-footer-address"><?php echo esc_html( $uttarakhand_tours_footer_address ); ?></li>
						<?php endif; ?>
					</ul>
				</div>
			<?php endif; ?>
		</div>
	</div>

	<div class="site-footer-legal">
		<p>&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?></p>
		<p><?php esc_html_e( 'Every journey is confirmed with you directly over the phone or WhatsApp. Nothing is reserved or charged on this site.', 'uttarakhand-tours' ); ?></p>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
