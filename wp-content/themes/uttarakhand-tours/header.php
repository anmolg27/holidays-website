<?php
/**
 * Site header, shared by every template.
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'uttarakhand-tours' ); ?></a>

<header class="site-header">
	<div class="site-header-inner">
		<div class="site-branding">
			<?php if ( has_custom_logo() ) : ?>
				<?php the_custom_logo(); ?>
			<?php else : ?>
				<a class="site-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
					<span class="site-brand-mark" aria-hidden="true"></span>
					<span><?php bloginfo( 'name' ); ?></span>
				</a>
			<?php endif; ?>
		</div>

		<nav class="primary-navigation" aria-label="<?php esc_attr_e( 'Primary navigation', 'uttarakhand-tours' ); ?>">
			<?php if ( has_nav_menu( 'primary' ) ) : ?>
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'primary',
						'container'      => false,
						'menu_class'     => 'primary-menu',
						'depth'          => 1,
					)
				);
				?>
			<?php else : ?>
				<ul class="primary-menu">
					<li><a href="<?php echo esc_url( get_post_type_archive_link( 'travel_package' ) ); ?>"><?php esc_html_e( 'Travel Packages', 'uttarakhand-tours' ); ?></a></li>
					<li><a href="<?php echo esc_url( home_url( '/about-us-fleet-hotels/' ) ); ?>"><?php esc_html_e( 'Our Story', 'uttarakhand-tours' ); ?></a></li>
					<li><a class="site-header-cta" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>"><?php esc_html_e( 'Plan a Journey', 'uttarakhand-tours' ); ?></a></li>
				</ul>
			<?php endif; ?>
		</nav>
	</div>
</header>

<main id="primary" class="site-main">
