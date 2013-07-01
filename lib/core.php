<?php
/**
 * Core functions of the theme.
 * 
 * @author WildWebLab
 * @link   http://wildweblab.com/theme/icy
 */


/**
 * Creates a nicely formatted and more specific title element text
 * for output in head of document, based on current view.
 *
 * @since 1.0
 *
 * @param string $title Default title text for current view.
 * @param string $sep Optional separator.
 * @return string Filtered title.
 */
function wwl_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() )
		return $title;

	// Add the blog name.
	$title .= get_bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title = "$title $sep $site_description";

	// Add a page number if necessary.
	if ( $paged >= 2 || $page >= 2 )
		$title = "$title $sep " . sprintf( __( 'Page %s', 'icy' ), max( $paged, $page ) );

	return $title;
}
add_filter( 'wp_title', 'wwl_wp_title', 10, 2 );


/**
 * Output markup of the logo in header.
 *
 * @since 1.0
 */
function wwl_logo() {
	if ( is_home() )
		$title_tag = 'h1';
	else
		$title_tag = 'div';

	?>
	<div id="logo">
		<<?php echo $title_tag; ?> id="site-title">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
		</<?php echo $title_tag; ?>>
		<span id="site-description"><?php bloginfo( 'description' ); ?></span>
	</div>
	<?php
}
add_action( 'wwl_header', 'wwl_logo' );


/**
 * Styles the header text displayed on the blog.
 *
 * @since 1.0
 */
function wwl_header_style() {
	$text_color = get_header_textcolor();
	$header_image = get_header_image();

	if ( empty( $text_color ) ) {
		$text_color == get_theme_support( 'custom-header', 'default-text-color' );
	}
	?>
	<style type="text/css">
	<?php
		// Has the text been hidden?
		if ( ! display_header_text() ) :
	?>
		#site-title,
		#site-description { text-indent: -9999px; }
	<?php
		endif;

		if(  ! empty( $header_image )  ) :
		?>
		#site-title,
		#site-description { 
			margin: 0;
			line-height: 0;
			text-indent: -9999px;
		}

		#site-title a {
			display: block;
			width: <?php echo get_custom_header()->width; ?>px;
			height: <?php echo get_custom_header()->height; ?>px;
			background: url('<?php echo esc_url( $header_image ); ?>') no-repeat;
		}
		
		<?php
		endif;

		// If the user has set a custom color for the text, use that.
		if ( ! empty( $text_color ) && display_header_text() ) :
	?>
		#site-title a {
			color: #<?php echo $text_color; ?> !important;
		}
	<?php endif; ?>
	</style>
	<?php
}


/**
 * Styles the header image displayed on the Appearance > Header admin panel.
 *
 * @since 1.0
 */
function wwl_admin_header_style() {
	$text_color = get_header_textcolor();
	$header_image = get_header_image();

	if ( empty( $text_color ) ) {
		$text_color == get_theme_support( 'custom-header', 'default-text-color' );
	}
	?>

	<style type="text/css">
	.appearance_page_custom-header #headimg {
		padding: 10px;
		border: none;
		background: #2185C5;
	}

	#headimg #site-title,
	#headimg #site-description {
		line-height: 1.6;
		margin: 0;
		padding: 0;
	}

	#headimg #site-title {
		font: 40px Georgia, serif;
	}

	#headimg #site-title a {
		<?php if ( ! empty( $text_color ) && display_header_text() ) : ?>
		color: #<?php echo $text_color; ?> !important;
		<?php else: ?>
		color: #fff;
		<?php endif; ?>
		text-shadow: 1px 1px 0 rgba(0, 0, 0, 0.2);
		text-decoration: none;
	}

	#headimg #site-title a:hover {
		<?php if ( ! empty( $text_color ) && display_header_text() ) : ?>
		color: #<?php echo $text_color; ?> !important;
		<?php else: ?>
		color: #fff;
		<?php endif; ?>
	}

	#headimg #site-description {
		margin-bottom: 10px;
		color: rgba(255, 255, 255, 0.7);
		font: normal 15px "HelveticaNeue-Light", "Helvetica Neue Light", "Helvetica Neue", sans-serif;
		text-shadow: none;
	}

	<?php if ( ! display_header_text() ) : ?>
		#site-title,
		#site-description { text-indent: -9999px; }
	<?php endif; ?>

	<?php if( ! empty( $header_image ) ) :?>
		#headimg #site-title,
		#headimg #site-description { 
			margin: 0 !important;
			line-height: 0 !important;
			text-indent: -9999px !important;
		}

		#headimg #site-title a {
			display: block;
			width: <?php echo get_custom_header()->width; ?>px;
			height: <?php echo get_custom_header()->height; ?>px;
			background: url('<?php echo esc_url( $header_image ); ?>') no-repeat;
		}
	<?php endif; ?>
	</style>
<?php
}


/**
 * Outputs markup to be displayed on the Appearance > Header admin panel.
 * This callback overrides the default markup displayed there.
 *
 * @since 1.0 
 */
function wwl_admin_header_image() {
	?>
	<div id="headimg">
		<h1 id="site-title">
			<a id="name" onclick="return false;" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>"><?php bloginfo( 'name' ); ?></a>
		</h1>
		<div id="site-description"><?php bloginfo( 'description' ); ?></div>
	</div>
<?php }


/**
 * Output social icons based on theme settings.
 * 
 * @since 1.0
 */
function wwl_social_icons() {
	echo '<div class="social-icons">';

	if( $facebook = of_get_option('facebook') )
		echo '<a href="' . $facebook . '"><i class="icon-facebook"></i></a>';
	if( $twitter = of_get_option('twitter') )
		echo '<a href="' . $twitter . '"><i class="icon-twitter"></i></a>';
	if( $gplus = of_get_option('gplus') )
		echo '<a href="' . $gplus . '"><i class="icon-gplus"></i></a>';
	if( $youtube = of_get_option('youtube') )
		echo '<a href="' . $youtube . '"><i class="icon-youtube"></i></a>';
	if( $vimeo = of_get_option('vimeo') )
		echo '<a href="' . $vimeo . '"><i class="icon-vimeo"></i></a>';
	if( $flickr = of_get_option('flickr') )
		echo '<a href="' . $flickr . '"><i class="icon-flickr"></i></a>';
	if( $pinterest = of_get_option('pinterest') )
		echo '<a href="' . $pinterest . '"><i class="icon-pinterest"></i></a>';
	if( $linkedin = of_get_option('linkedin') )
		echo '<a href="' . $linkedin . '"><i class="icon-linkedin"></i></a>';
	if( $tumblr = of_get_option('tumblr') )
		echo '<a href="' . $tumblr . '"><i class="icon-tumblr"></i></a>';
	if( $rss = of_get_option('rss') )
		echo '<a href="' . $rss . '"><i class="icon-rss"></i></a>';

	echo '</div>';
}


/**
 * Add social icons to header.
 * 
 * @since 1.0
 *
 * @uses wwl_social_icons() Get social icons
 */
function wwl_social_icons_in_header() {
	$enable_social_icons = of_get_option('enable_social_icons');
	
	if( $enable_social_icons['enabled'] == 1 ) {
		wwl_social_icons();
	}
}
add_action( 'wwl_header', 'wwl_social_icons_in_header' );


/**
 * Add widget area to header.
 * 
 * @since 1.0
 */
function wwl_header_widgets() {
	if ( is_active_sidebar('header-widget-area') ) {
		echo '<div id="header-widget">';
		dynamic_sidebar('header-widget-area');
		echo '</div>';
	}
}
add_action( 'wwl_header', 'wwl_header_widgets' );


/**
 * Add container to header.
 * 
 * @since 1.0
 */
function wwl_header_container_open() {
	echo '<div class="container">';
}
add_action( 'wwl_header', 'wwl_header_container_open', 1 );


/**
 * Close container in header.
 * 
 * @since 1.0
 */
function wwl_header_container_close() {
	echo '</div>';
	echo '<div class="clearfix"></div>';
}
add_action( 'wwl_header', 'wwl_header_container_close' );


/**
 * Output primary navigation in header.
 * 
 * @since 1.0
 *
 * @uses wwl_walker_nav_menu_dropdown() Change markup for mobile menu
 */
function wwl_primary_navigation() {
	echo '<nav class="nav nav-primary">';

	wp_nav_menu( array( 
		'theme_location' => 'primary',
		'fallback_cb' => false,
		'container' => 'div',
		'container_class' => 'container',
		'menu' => 'ul',
		'menu_class' => 'menu',
		'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
	) );

	$mobile_wrap = '<span class="mobile-menu-text">Navigation</span><i class="mobile-menu-icon icon-menu"></i>
		<select class="mobile-menu">
			<option value="">Navigation</option>
			%3$s
		</select>';

	wp_nav_menu(array(
		'theme_location' => 'primary',
		'fallback_cb' => false,
		'walker' => new wwl_walker_nav_menu_dropdown(),
		'items_wrap' => $mobile_wrap,
		'container' => 'div',
		'container_class' => 'container',
	));

	echo '</nav>';
}
add_action( 'wwl_header', 'wwl_primary_navigation' );


/**
 * Output post info above the post title.
 * 
 * @since 1.0
 */
function wwl_post_info() {
	if( 'post' == get_post_type() ) {
		if( $post_info = apply_filters( 'wwl_post_info', of_get_option('post_info') ) ) {
			printf( '<div class="entry-info">%1$s</div>', 
				$post_info
			);
		}
	}
}
add_action( 'wwl_before_post_title', 'wwl_post_info' );
add_filter( 'wwl_post_info', 'do_shortcode', 20 );


/**
 * Output post meta under the post content.
 * 
 * @since 1.0
 */
function wwl_post_meta() {
	if( 'post' == get_post_type() ) {
		if( $post_meta = apply_filters( 'wwl_post_meta', of_get_option('post_meta') ) ) {
			printf( '<footer class="entry-meta">%1$s</footer>', 
				$post_meta
			);
		}
	}
}
add_action( 'wwl_after_post_content', 'wwl_post_meta' );
add_filter( 'wwl_post_meta', 'do_shortcode', 20 );


/**
 * Output edit link under the content of a page.
 * 
 * @since 1.0
 */
function wwl_page_meta() {
	global $id;

	if( is_page() ) {
		if( $edit_link = get_edit_post_link( $id ) ) {
			printf( '<footer class="entry-meta"><span class="edit-link"><a class="post-edit-link" href="%1$s" title="Edit Page">%2$s</a></span></footer>', 
				$edit_link,
				__( 'Edit', 'icy' )
			);
		}
	}
}
add_action( 'wwl_after_post_content', 'wwl_page_meta' );


/**
 * Output author bio under post.
 * 
 * @since 1.0
 */
function wwl_author_bio() {
	if ( is_single() && get_the_author_meta( 'description' ) ) {
		get_template_part( 'author-bio' );	
	}
}
add_action( 'wwl_after_post', 'wwl_author_bio' );


/**
 * Output widgets in footer.
 * 
 * @since 1.0
 */
function wwl_footer_widgets() {
	$widgets_count = is_active_sidebar('1-footer-widget-area') + 
					 is_active_sidebar('2-footer-widget-area') + 
					 is_active_sidebar('3-footer-widget-area') + 
					 is_active_sidebar('4-footer-widget-area');
	
	if( $widgets_count ) : 
	
	$grid_class = 'span' . ( 12 / $widgets_count );
	?>
	<div id="footer-widgets" class="container">
		<?php 
		for ( $i = 1; $i <= 4; $i++ ):
			if ( is_active_sidebar($i . '-footer-widget-area') ) : 
			?>
			<div class="<?php echo $grid_class; ?>">
				<?php dynamic_sidebar($i . '-footer-widget-area'); ?>
			</div>
			<?php 
			endif; 
		endfor;
		?>
	</div>

	<?php endif;
}
add_action( 'wwl_footer', 'wwl_footer_widgets' );


/**
 * Output page pagination.
 *
 * @since 1.0
 */
function wwl_pagination() {
	global $wp_query;
	
	if (  $wp_query->max_num_pages > 1 ) {
		echo '<div class="page-navigation">';
		
		if( of_get_option('pagination_style') == 1 ) {
			if( function_exists( 'wp_pagenavi' ) ) {
				wp_pagenavi();
			} else {
				$big = 999999999;
				
				 echo paginate_links( array(
					'base' => str_replace( $big, '%#%', get_pagenum_link( $big ) ),
					'format' => '?paged=%#%',
					'current' => max( 1, get_query_var('paged') ),
					'total' => $wp_query->max_num_pages,
					'prev_text' => '&larr; <span class="prev">' . __( 'Previous', 'icy' ) . '</span>',
					'next_text' => '<span class="next">' . __( 'Next', 'icy' ) . '</span> &rarr;'
				) ); 
			}
		} else {
			?>
				<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'icy' ) ); ?> </div>
				<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'icy' ) ); ?> </div>
			<?php
		}
		
		echo '<div class="clearfix"></div>';
		echo '</div>';
	}
}


/**
 * Output breadcrumbs.
 * 
 * @since 1.0
 */
function wwl_breadcrumbs() {
	global $wp_query;
	
	if ( function_exists( 'yoast_breadcrumb' ) ) {
		yoast_breadcrumb( '<div class="breadcrumb">', '</div>' );
	}
	elseif ( function_exists( 'bcn_display' ) ) {
		echo '<div class="breadcrumb">';
		bcn_display();
		echo '</div>';
	}
	elseif ( function_exists( 'breadcrumbs' ) ) {
		breadcrumbs();
	}
	elseif ( function_exists( 'crumbs' ) ) {
		crumbs();
	}
	else {
		$settings = of_get_option('breadcrumbs');
		
		$before = '<div class="breadcrumb">';
		$after = '</div>';
		$sep = '<span class="divider">&raquo;</span>';
		$home_link = '<a href="' . home_url() . '">' . __( 'Home', 'icy' ) . '</a>' . $sep;
		
		if ( is_paged() && $settings['front_page'] ) {
			echo $before . $home_link . __( 'Page ', 'icy' ) . $wp_query->query_vars['paged'] . $after;
		} elseif( is_home() && $settings['front_page'] ) {
			echo $before . __( 'Home', 'icy' ) . $after;
		} elseif ( is_single() && $settings['posts'] ) {
			$category = get_the_category();
			
			echo $before . $home_link. '<a href="' . get_category_link( $category[0]->cat_ID ) . '">' . $category[0]->cat_name . '</a>' . $sep;
			the_title();
			echo $after;
		} elseif ( is_page() && $settings['pages'] ) {
			echo $before . $home_link;
			the_title();
			echo $after;
		}
		elseif( is_archive() && $settings['archives'] ) {
			echo $before . $home_link;
			
			if ( is_category() ) {
				_e( 'Category: ', 'icy' );
				$category = get_the_category();
				echo $category[0]->cat_name;
			} elseif( is_tag()) {
				_e( 'Tag: ', 'icy' ); 
				single_tag_title();
			} elseif ( is_day() ) {
				_e( 'Archive for: ', 'icy' ); 
				echo get_the_date();
			} elseif ( is_month() ) { 
				_e( 'Archive for: ', 'icy' ); 
				echo get_the_date( 'F Y' );
			} elseif ( is_year() ) {
				_e( 'Archive for: ', 'icy' ); 
				echo get_the_date( 'Y' );
			} elseif ( is_author() ) {
				the_post();
				_e( 'Author Archives: ', 'icy' ) . the_author();
				rewind_posts();
			} 
			
			echo $after;
		} elseif ( is_search() && $settings['archives'] ) {
			echo $before . $home_link . __( 'Search Results for: ', 'icy' ) . get_search_query() . $after;
		} elseif ( is_404() && $settings['404_page'] ) {
			echo $before . $home_link . __( 'Page Not Found', 'icy' ) . $after;
		}
	}
}
add_action( 'wwl_open_content', 'wwl_breadcrumbs' );


/**
 * Register default layouts for the theme.
 * 
 * @since 1.0
 */
function wwl_layouts_init() {
	wwl_register_layout(
		'cs', 
		array(
			'label' => __('Content Sidebar', 'icy'),
			'img' => 'cs.gif',
			'sidebar' => array('primary')
		)
	);

	wwl_register_layout(
		'sc', 
		array(
			'label' => __('Sidebar Content', 'icy'),
			'img' => 'sc.gif',
			'sidebar' => array('primary')
		)
	);
	
	wwl_register_layout(
		'c', 
		array(
			'label' => __('Content', 'icy'),
			'img' => 'c.gif',
			'sidebar' => array()
		)	
	);
}
add_action( 'wwl_init', 'wwl_layouts_init', 0 );


/**
 * Add new layout.
 * 
 * @since 1.0
 *
 * @global array $_wwl_layouts
 * @return array Updated array of registered layouts
 */
function wwl_register_layout( $layout, $args = array() ) {
	global $_wwl_layouts;

	if( ! isset($_wwl_layouts) && ! is_array($_wwl_layouts) )
		$_wwl_layouts = array();

	if( array_key_exists( $layout, $_wwl_layouts ) )
		return false;

	return $_wwl_layouts[$layout] = $args;
}


/**
 * Unregister layout.
 * 
 * @since 1.0
 *
 * @global array $_wwl_layouts
 * @return bool true
 */
function wwl_unregister_layout( $layout ) {
	global $_wwl_layouts;

	unset( $_wwl_layouts[$layout] );

	return true;
}


/**
 * Returns all registered layouts.
 * 
 * @since 1.0
 *
 * @global array $_wwl_layouts
 * @return array Registered layouts
 */
function wwl_get_layouts() {
	global $_wwl_layouts;

	if( ! isset($_wwl_layouts) && ! is_array($_wwl_layouts) )
		$_wwl_layouts = array();

	return $_wwl_layouts;
}


/**
 * Return data layout based on layout ID.
 * 
 * @since 1.0
 *
 * @param string $layout Layout ID.
 * @global array $_wwl_layouts
 * @return array Layout data
 */
function wwl_get_layout( $layout ) {
	global $_wwl_layouts;

	if( ! isset($_wwl_layouts) && ! array_key_exists( $layout, $_wwl_layouts ) )
		return false;

	return $_wwl_layouts[$layout];
}


/**
 * Return currently set layout.
 * 
 * @since 1.0
 *
 * @return string Layout ID
 */
function wwl_get_active_layout() {
	global $post;

	if( is_single() || is_page() ) {
		$post_layout = get_post_meta( $post->ID, 'wwl_layout', true );
		
		if( $post_layout && $post_layout != '0' ) {
			return $post_layout;
		}
	}
	
	return of_get_option('theme_layout');
}


/**
 * Add custom CSS class to the <body> tag to change layout.
 *
 * @since 1.0
 *
 * @param array $existing_classes Existing body classes
 * @uses wwl_get_active_layout() Get current layout
 * @return array Modified body classes
 */
function wwl_layout_classes( $existing_classes ) {
	$layout = wwl_get_active_layout();

	$classes = array( 'layout-' . $layout );

	$classes = apply_filters( 'wwl_layout_classes', $classes, $layout );

	return array_merge( $existing_classes, $classes );
}
add_filter( 'body_class', 'wwl_layout_classes' );


/**
 * Check if sidebar is active based on sidebar ID.
 *
 * @since 1.0
 *
 * @param string $name Name of a sidebar
 * @uses wwl_get_active_layout() Get current layout
 * @return bool True if sidebar is active
 */
function wwl_is_active_sidebar( $name ) {
	$active_layout = wwl_get_active_layout(); 

	$layout = wwl_get_layout($active_layout);

	if( in_array( $name, $layout['sidebar'] ) )
		return true;
	else
		return false;
}


/**
 * Template for comments and pingbacks.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 * 
 * @since 1.0
 */
function wwl_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php _e( 'Pingback:', 'icy' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( 'Edit', 'icy' ), ' ' ); ?></p>
	<?php
			break;
		default :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" class="comment">
			<footer>
				<div class="comment-author vcard">
					<?php echo get_avatar( $comment, 45 ); ?>
					<?php printf( __( '%s ', 'icy' ), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?>
				</div>
				
				<div class="comment-meta commentmetadata">
					<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
						<time pubdate datetime="<?php comment_time( 'c' ); ?>">
						<?php printf( __( '%1$s at %2$s', 'icy' ), get_comment_date(), get_comment_time() ); ?>
						</time>
					</a>
					<?php edit_comment_link( __( 'Edit', 'icy' ), ' ' );
					?>
				</div>
				
				<?php if ( $comment->comment_approved == '0' ) : ?>
				<div class="comment-moderation">
					<em><?php _e( 'Your comment is awaiting moderation.', 'icy' ); ?></em>
				</div>
				<?php endif; ?>
			</footer>

			<div class="comment-content"><?php comment_text(); ?></div>

			<div class="reply">
				<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
			</div>
		</article> 
	<?php
			break;
	endswitch;
}


/**
 * Adds a box to the main column on the Post and Page edit screens
 * 
 * @since 1.0
 */
function wwl_add_custom_layout() {
   add_meta_box( 
        'wwl_layout',
        __( 'Layout Settings', 'icy' ),
        'wwl_inner_custom_layout',
        'post',
		'normal',
		'default'
    );
	
    add_meta_box(
        'wwl_layout',
        __( 'Layout Settings', 'icy' ), 
        'wwl_inner_custom_layout',
        'page',
		'normal',
		'default'
    );
}
add_action( 'add_meta_boxes', 'wwl_add_custom_layout' );


/**
 * Prints the box content
 * 
 * @since 1.0
 */
function wwl_inner_custom_layout( $post ) {
	wp_nonce_field( basename( __FILE__ ), 'wwl_custom_layout_nonce' );

	?>
	<p>
		<input type="radio" id="wwl_layout_d" name="wwl_layout" value="" <?php if ( ! get_post_meta( $post->ID, 'wwl_layout', true ) ) echo 'checked="checked"'; ?> /> 
		<label for="wwl_layout_d"><?php _e("Default Theme Layout", 'icy' ); ?></label>
	</p>
	
	<p id="wwl-layout-options">
		<?php
		foreach( wwl_get_layouts() as $id => $args ) {
			?>
			<input type="radio" id="wwl_layout_<?php echo $id; ?>" name="wwl_layout" value="<?php echo $id; ?>"<?php if ( get_post_meta( $post->ID, 'wwl_layout', true ) == $id ) echo ' checked="checked"' ?> />
			<label for="wwl_layout_<?php echo $id; ?>"><img src="<?php echo WWL_ADMIN_IMG_URL . $args['img']; ?>" /></label>
			<?php
		}
		?>
	</p>
	<?php
}


/**
 * Save custom settings of the post or page layout.
 * 
 * @since 1.0
 */
function wwl_save_custom_layout( $post_id, $post ) {
	if ( ! isset( $_POST['wwl_custom_layout_nonce'] ) || ! wp_verify_nonce( $_POST['wwl_custom_layout_nonce'], basename( __FILE__ ) ) )
		return $post_id;
		
	$post_type = get_post_type_object( $post->post_type );
	
	if ( ! current_user_can( $post_type->cap->edit_post, $post_id ) )
		return $post_id;

	$new_meta_value = ( isset( $_POST['wwl_layout'] ) ? sanitize_html_class( $_POST['wwl_layout'] ) : '' );
	
	$meta_key = 'wwl_layout';
	
	/* Get the meta value of the custom field key. */
	$meta_value = get_post_meta( $post_id, $meta_key, true );
	
	/* If a new meta value was added and there was no previous value, add it. */
	if ( $new_meta_value && '' == $meta_value )
		add_post_meta( $post_id, $meta_key, $new_meta_value, true );
	/* If the new meta value does not match the old value, update it. */
	elseif ( $new_meta_value && $new_meta_value != $meta_value )
		update_post_meta( $post_id, $meta_key, $new_meta_value );
	/* If there is no new meta value but an old value exists, delete it. */
	elseif ( '' == $new_meta_value && $meta_value )
		delete_post_meta( $post_id, $meta_key, $meta_value );
}
add_action( 'save_post', 'wwl_save_custom_layout', 10, 2 );


/**
 * Output the thumbnail of a post if exists and is enabled in the Theme Options.
 * 
 * @since 1.0
 */
function wwl_post_thumbnail() {
	if ( has_post_thumbnail() ) :
		$featured_image = of_get_option('featured_image');
		$size = of_get_option('featured_image_size');
		
		if( is_home() && $featured_image['front_page'] ||
			is_archive() && $featured_image['archive_pages'] ||
			is_search() && $featured_image['search_results'] ) :
		?>
			<div class="post-thumbnail">
				<a href="<?php the_permalink(); ?>">
					<?php the_post_thumbnail($size); ?>
					<div class="clearfix"></div>
				</a>
			</div>
		<?php
		elseif( is_single() && $featured_image['single_posts'] ) :
			?> 
			<div class="post-thumbnail">
				<?php
				the_post_thumbnail($size);
				?> 
			</div>
			<?php
		endif;
	endif;
}


/**
 * Output the excerpt or full content of a post.
 * 
 * @since 1.0 
 *
 * @uses wwl_post_thumbnail() Get post thumbnail
 */
function wwl_post_content() {
	do_action( 'wwl_before_post_content' ); // Hook

	if ( ! is_single() && of_get_option('post_content') == 2 || is_search() ) :
	?>
		<div class="entry-summary">
			<?php wwl_post_thumbnail(); ?>
			<?php the_excerpt(); ?>
			<div class="clearfix"></div>
		</div><!-- .entry-summary -->
	<?php else : ?>
		<div class="entry-content">
			<?php wwl_post_thumbnail(); ?>
			<?php the_content( __( 'Read More', 'icy' ) ); ?>
			<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'icy' ), 'after' => '</div>' ) ); ?>
			<div class="clearfix"></div>
		</div><!-- .entry-content -->
	<?php endif;

	do_action( 'wwl_after_post_content' ); // Hook
}


/**
 * Output custom scripts from theme options in header.
 *
 * @since 1.0
 */
function wwl_custom_header_scripts() {
	if( $header_scripts = of_get_option('header_scripts') )
		echo $header_scripts;
}
add_action( 'wp_head', 'wwl_custom_header_scripts' );


/**
 * Output custom scripts from theme options in footer.
 *
 * @since 1.0
 */
function wwl_custom_footer_scripts() {
	if( $footer_scripts = of_get_option('footer_scripts') )
		echo $footer_scripts;
}
add_action( 'wp_footer', 'wwl_custom_footer_scripts' );


/**
 * Outputs custom styling.
 *
 * @since 1.0
 *
 * @uses wwl_generate_font_css() Get font css based on settings
 */
function wwl_print_custom_style() {
	$style = '';

	// POST FORMAT ICONS
	$hide_post_format_icons = of_get_option('hide_post_format_icons');

	if( $hide_post_format_icons['enabled']  == 1 ) {
		$style .= '.post-format-indicator{display:none;}';
	}
	
	$style .= of_get_option('custom_css');
	
	echo '<style type="text/css" id="custom-css">' . $style . '</style>';
}
add_action( 'wp_head', 'wwl_print_custom_style' );


/**
 * Generate select menu for mobile
 *
 * @since 1.0
 */
class wwl_walker_nav_menu_dropdown extends walker_nav_menu {
    function start_lvl( &$output, $depth ) {
		$indent = str_repeat("\t", $depth);
    }

    function end_lvl( &$output, $depth ) {
		$indent = str_repeat("\t", $depth); 
    }

    function start_el( &$output, $item, $depth, $args ) {
		$item->title = str_repeat("&nbsp;", $depth * 4) . $item->title;
		$output .= '<option value="' . $item->url . '">' . $item->title . "</option>\n";
    }
	
    function end_el( &$output, $item, $depth ) {
    }
}