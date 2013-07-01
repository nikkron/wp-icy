<?php
/**
 * The main template file.
 * 
 * @author WildWebLab
 * @link   http://wildweblab.com/theme/icy
 */


get_header();

do_action( 'wwl_before_loop' ); // Hook

if ( have_posts() ) {
	while ( have_posts() ) { the_post(); 
		do_action( 'wwl_before_post' ); // Hook

		get_template_part( 'content', get_post_format() );

		do_action( 'wwl_after_post' ); // Hook
	}

	wwl_pagination();
} else {
	get_template_part( 'content', 'noresults' );
}

do_action( 'wwl_after_loop' ); // Hook

get_sidebar();

get_footer();