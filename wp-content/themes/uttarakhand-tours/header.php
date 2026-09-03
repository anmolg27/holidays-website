<?php
/**
 * Site header, shared by every template.
 *
 * Landmarks first: a skip link, a banner with the brand and the Primary
 * menu, then the <main> container every template's sections render into.
 * The Primary menu falls back to inc/navigation.php's generated list until
 * the client builds a menu in wp-admin.
 */

$uttarakhand_tours_contact_url = uttarakhand_tours_get_page_url( UTTARAKHAND_TOURS_CONTACT_PAGE_SLUG );
$uttarakhand_tours_tagline     = get_bloginfo( 'description', 'display' );
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

<a class="skip-link" href="#site-main"><?php esc_html_e( 'Skip to content', 'uttarakhand-tours' ); ?></a>

<header class="site-header">
	<div class="site-header-inner">
		<div class="site-brand">
			<?php if ( has_custom_logo() ) : ?>
				<?php the_custom_logo(); ?>
			<?php else : ?>
				<a class="site-brand-link" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
					<span class="site-brand-name"><?php bloginfo( 'name' ); ?></span>
					<?php if ( $uttarakhand_tours_tagline ) : ?>
						<span class="site-brand-tagline"><?php echo esc_html( $uttarakhand_tours_tagline ); ?></span>
					<?php endif; ?>
				</a>
			<?php endif; ?>
		</div>

		<nav class="site-nav" aria-label="<?php esc_attr_e( 'Primary', 'uttarakhand-tours' ); ?>">
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'primary',
					'container'      => false,
					'menu_class'     => 'site-nav-list',
					'depth'          => 1,
					'fallback_cb'    => 'uttarakhand_tours_default_primary_menu',
				)
			);
			?>
		</nav>

		<?php if ( $uttarakhand_tours_contact_url && ! is_page( UTTARAKHAND_TOURS_CONTACT_PAGE_SLUG ) ) : ?>
			<a class="site-header-cta" href="<?php echo esc_url( $uttarakhand_tours_contact_url ); ?>"><?php esc_html_e( 'Plan your trip', 'uttarakhand-tours' ); ?></a>
		<?php endif; ?>
	</div>
</header>

<main id="site-main" class="site-main">
