<?php
/**
 * Standard Page template.
 *
 * Purely editorial content, edited via the standard WordPress block editor —
 * no custom fields or post types involved. Used for pages like About Us &
 * Fleet/Hotels (see inc/about-fleet-page.php).
 */

get_header();

while ( have_posts() ) :
	the_post();
	?>
	<article <?php post_class(); ?>>
		<h1 class="page-title"><?php the_title(); ?></h1>

		<div class="page-content">
			<?php the_content(); ?>
		</div>
	</article>
	<?php
endwhile;

get_footer();
