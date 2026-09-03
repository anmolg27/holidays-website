<?php
/**
 * Site header, shared by every template.
 *
 * The Lora display face is preloaded here since it's used by the
 * site-wide wordmark, which paints on every page's first viewport.
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="preload" href="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/fonts/lora-600-latin.woff2' ); ?>" as="font" type="font/woff2" crossorigin>
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="site-header">
	<div class="site-header-row">
		<a class="site-wordmark" href="<?php echo esc_url( home_url( '/' ) ); ?>">Uttarakhand Tours</a>

		<?php echo uttarakhand_tours_render_primary_nav(); ?>
	</div>

	<div class="flag-band" aria-hidden="true"></div>
</header>
