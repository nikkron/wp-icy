<?php
/**
 * Defines shortcodes functions.
 * 
 * @author WildWebLab
 * @link   http://wildweblab.com/theme/icy
 */


/**
 * Return Full Copyright.
 *
 * @since 1.0
 */
function wwl_footer_copyright() {
	return get_bloginfo('name') . ' &copy; ' . date('Y');
}
add_shortcode( 'footer_copyright', 'wwl_footer_copyright' );


/**
 * Link to WordPress.
 *
 * @since 1.0
 */
function wwl_footer_wordpress_link() {
	return '<a href="http://wordpress.org/">WordPress</a>';
}
add_shortcode( 'footer_wordpress_link', 'wwl_footer_wordpress_link' );


/**
 * Link to WildWebLab.
 *
 * @since 1.0
 */
function wwl_footer_wildweblab_link() {
	return '<a href="http://wildweblab.com/">WildWebLab</a>';
}
add_shortcode( 'footer_wildweblab_link', 'wwl_footer_wildweblab_link' );


/**
 * Link to Post Autor.
 *
 * @since 1.0
 *
 * @param array $atts Shortcode attributes
 * @return string Shortcode output
 */
function wwl_post_author( $atts ) {
	$defaults = array(
		'before' => '',
		'after'  => '',
	);

	$atts = shortcode_atts( $defaults, $atts );

	return sprintf( '%1$s<span class="author vcard"><a class="url fn n" href="%2$s" title="%3$s">%4$s</a></span>%5$s',
		$atts['before'],
		get_author_posts_url( get_the_author_meta( 'ID' ) ),
		sprintf( esc_attr__( 'View all posts by %s', 'icy' ), get_the_author() ),
		get_the_author(),
		$atts['after']
	);
}
add_shortcode( 'post_author', 'wwl_post_author' );


/**
 * Post Date.
 *
 * @since 1.0
 *
 * @param array $atts Shortcode attributes
 * @return string Shortcode output
 */
function wwl_post_date( $atts ) {
	$defaults = array(
		'before' => '',
		'after'  => '',
	);

	$atts = shortcode_atts( $defaults, $atts );
		
	return sprintf( '%1$s<span class="entry-date"><a href="%2$s" title="%3$s" rel="bookmark">%4$s</a></span>%5$s',
		$atts['before'],
		get_permalink(),
		esc_attr( get_the_time() ),
		get_the_date(),
		$atts['after']
	);
}
add_shortcode( 'post_date', 'wwl_post_date' );


/**
 * Link Edit.
 *
 * @since 1.0
 *
 * @param array $atts Shortcode attributes
 * @return string Shortcode output
 */
function wwl_post_edit( $atts ) {
	if( $edit_link = get_edit_post_link() ) {
		
		$defaults = array(
			'before' => '&middot; ',
			'after'  => '',
		);
		$atts = shortcode_atts( $defaults, $atts );
		
		return sprintf( '%1$s<span class="edit-link"><a href="%2$s">%3$s</a></span>%4$s',
			$atts['before'],
			$edit_link,
			__( 'Edit', 'icy' ),
			$atts['after']
		);
	}
}
add_shortcode( 'post_edit', 'wwl_post_edit' );


/**
 * Post Tags.
 *
 * @since 1.0
 *
 * @param array $atts Shortcode attributes
 * @return string Shortcode output
 */
function wwl_post_tags( $atts ) {
	if( $tags = get_the_tag_list( '', ', ' ) ) {
		
		$defaults = array(
			'before' => __( 'Tags: ', 'icy' ),
			'after'  => '. ',
		);
		$atts = shortcode_atts( $defaults, $atts );
		
		return sprintf( '%1$s<span class="entry-tags">%2$s</span>%3$s',
			$atts['before'],
			$tags,
			$atts['after']
		);
	}
}
add_shortcode( 'post_tags', 'wwl_post_tags' );


/**
 * Post Categories.
 *
 * @since 1.0
 *
 * @param array $atts Shortcode attributes
 * @return string Shortcode output
 */
function wwl_post_categories( $atts ) {
	if( $categories = get_the_category_list( ', ' ) ) {
	
		$defaults = array(
			'before' => __( 'Posted in: ', 'icy' ),
			'after'  => '. ',
		);
		$atts = shortcode_atts( $defaults, $atts );

		return sprintf( '%1$s<span class="entry-categories">%2$s</span>%3$s',
			$atts['before'],
			$categories,
			$atts['after']
		);
	}
}
add_shortcode( 'post_categories', 'wwl_post_categories' );


/**
 * Link to Post Comments.
 *
 * @since 1.0
 *
 * @param array $atts Shortcode attributes
 * @return string Shortcode output
 */
function wwl_post_comments( $atts ) {
	if ( comments_open() ) {
		ob_start();
		comments_popup_link( __( '0', 'icy' ), __( '1', 'icy' ), __( '%', 'icy' ) );
		$comments_link = ob_get_clean();
		
		$defaults = array(
			'before' => ' &middot; ',
			'after'  => '',
		);
		$atts = shortcode_atts( $defaults, $atts );
		
		return sprintf( '<span class="comments-link">%1$s</span>',
			$atts['before'] . $comments_link . $atts['after']
		);
	}
}
add_shortcode( 'post_comments', 'wwl_post_comments' );