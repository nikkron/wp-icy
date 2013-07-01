<?php
/**
 * The template for displaying Archive pages.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 * 
 * @author WildWebLab
 * @link   http://wildweblab.com/theme/icy
 */

get_header();

//get_template_part( 'archive', 'header' );

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