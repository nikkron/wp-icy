<?php
/**
 * The template for displaying all single posts.
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
		
		if ( comments_open() || '0' != get_comments_number() )
			comments_template( '', true );
	}
} else {
	get_template_part( 'content', 'noresults' );
}

do_action( 'wwl_after_loop' ); // Hook

get_sidebar();

get_footer();