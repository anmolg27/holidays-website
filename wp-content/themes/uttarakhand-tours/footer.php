<?php
/**
 * Site footer, shared by every template.
 */
?>
</main>

<footer class="site-footer">
	<div class="site-footer-inner">
		<div>
			<p class="site-footer-name"><?php bloginfo( 'name' ); ?></p>
			<p class="site-footer-heading"><?php esc_html_e( 'Thoughtful journeys through Uttarakhand.', 'uttarakhand-tours' ); ?></p>
		</div>

		<nav class="footer-navigation" aria-label="<?php esc_attr_e( 'Footer navigation', 'uttarakhand-tours' ); ?>">
			<a href="<?php echo esc_url( get_post_type_archive_link( 'travel_package' ) ); ?>"><?php esc_html_e( 'Explore Travel Packages', 'uttarakhand-tours' ); ?></a>
			<a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>"><?php esc_html_e( 'Request a Custom Package', 'uttarakhand-tours' ); ?></a>
		</nav>

		<p class="site-footer-meta">&copy; <?php echo esc_html( wp_date( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?></p>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
