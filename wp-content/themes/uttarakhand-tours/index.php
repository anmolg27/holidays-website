<?php
/**
 * Fallback template. Required by WordPress for every classic theme.
 */

get_header();

if ( have_posts() ) {
	while ( have_posts() ) {
		the_post();
		the_title( '<h1>', '</h1>' );
		the_content();
	}
} else {
	esc_html_e( 'Nothing found.', 'uttarakhand-tours' );
}

get_footer();
