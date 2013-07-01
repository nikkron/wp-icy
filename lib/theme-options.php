<?php
/**
 * A unique identifier is defined to store the options in the database and reference them from the theme.
 * By default it uses the theme name, in lowercase and without spaces, but this can be changed if needed.
 * If the identifier changes, it'll appear as if the options have been reset.
 *
 * @author WildWebLab
 * @link   http://wildweblab.com/theme/icy
 */
 

/**
 * Set ID for theme settings.
 * 
 * @since 1.0
 */
function optionsframework_option_name() {
	$optionsframework_settings = get_option( 'optionsframework' );
	$optionsframework_settings['id'] = WWL_SETTINGS_ID;
	update_option( 'optionsframework', $optionsframework_settings );
}


/**
 * Defines an array of options that will be used to generate the settings page and be saved in the database.
 * When creating the 'id' fields, make sure to use all lowercase and no spaces.
 *
 * If you are making your theme translatable, you should replace 'options_framework_theme'
 * with the actual text domain for your theme.  Read more:
 * http://codex.wordpress.org/Function_Reference/load_theme_textdomain
 *
 * @since 1.0
 *
 * @return array Theme Options
 */
function optionsframework_options() {	
	$typography_defaults = array(
		'size' => '15px',
		'face' => 'georgia',
		'style' => 'normal',
		'color' => '' 
	);

	$layouts = array();

	foreach( wwl_get_layouts() as $id => $args ) {
		$layouts[$id] = WWL_ADMIN_IMG_URL . $args['img'];
	}

	
	$options = array();

	/*
	 * GENERAL
	 */

	$options[] = array(
		'name' => __('General', 'icy'),
		'type' => 'heading',
		'icon' => 'icon-globe'
	);
	
	$options['theme_layout'] = array(
		'name' => __('Layout', 'icy'),
		'desc' => '',
		'id' => 'theme_layout',
		'std' => 'cs',
		'type' => 'images',
		'options' => $layouts
	);

	$options[] = array(
		'name' => __('Post Content', 'icy'),
		'id' => 'post_content',
		'std' => '1',
		'type' => 'select',
		'options' => array(
			'1' => 'Full Content',
			'2' => 'The Excerpt',
		)
	);

	$options[] = array(
		'name' => __('Featured Image', 'icy'),
		'desc' => __('', 'icy'),
		'id' => 'featured_image',
		'std' => array( 'front_page' => 1 ),
		'type' => 'multicheck',
		'options' => array(
			'front_page' => 'Front Page',
			'archive_pages' => 'Archive Pages',
			'single_posts' => 'Single Posts',
			'search_results' => 'Search Results',
		)
	);

	$options[] = array(
		'name' => __('Featured Image Size', 'icy'),
		'id' => 'featured_image_size',
		'std' => 'wwl-large',
		'type' => 'select',
		'options' => array(
			'thumbnail' => 'Thumbnail (150 x 150)',
			'medium' => 'Medium (300 x 200)',
			'wwl-large' => 'Large (640 x 300)',
		)
	);

	/*
	 * Hide Breadcrumbs options when one of those plugins is active.
	 */

	if ( ! function_exists( 'yoast_breadcrumb' ) &&
		 ! function_exists( 'bcn_display' ) &&
		 ! function_exists( 'breadcrumbs' )  && 
		 ! function_exists( 'crumbs' ) ) 
	{
		$options[] = array(
			'name' => __('Breadcrumbs', 'icy'),
			'desc' => __('', 'icy'),
			'id' => 'breadcrumbs',
			'std' => array( 'archives' => 1 ),
			'type' => 'multicheck',
			'options' => array(
				'front_page' => 'Front Page',
				'posts' => 'Posts',
				'pages' => 'Pages',
				'archives' => 'Archives',
				'404_page' => '404 Page',
			)
		);
	}
	
	$options[] = array(
		'name' => __('Pagination Style', 'icy'),
		'desc' => __('', 'icy'),
		'id' => 'pagination_style',
		'std' => '1',
		'type' => 'select',
		'options' => array(
			'1' => 'Numbers',
			'2' => 'Older posts / Newer posts',
		)
	);

	/*
	 * SOCIAL
	 */

	$options[] = array(
		'name' => __('Social', 'icy'),
		'type' => 'heading',
		'icon' => 'icon-link'
	);

	$options[] = array(
		'name' => __('Show Icons in Header', 'icy'),
		'desc' => __('', 'icy'),
		'id' => 'enable_social_icons',
		'std' => array( 'enabled' => 0 ),
		'type' => 'multicheck',
		'options' => array(
			'enabled' => 'Enable',
		)
	);

	$options[] = array(
		'name' => __('Facebook', 'icy'),
		'desc' => __('', 'icy'),
		'id' => 'facebook',
		'std' => '',
		'type' => 'text'
	);

	$options[] = array(
		'name' => __('Twitter', 'icy'),
		'desc' => __('', 'icy'),
		'id' => 'twitter',
		'std' => '',
		'type' => 'text'
	);

	$options[] = array(
		'name' => __('Google+', 'icy'),
		'desc' => __('', 'icy'),
		'id' => 'gplus',
		'std' => '',
		'type' => 'text'
	);

	$options[] = array(
		'name' => __('Youtube', 'icy'),
		'desc' => __('', 'icy'),
		'id' => 'youtube',
		'std' => '',
		'type' => 'text'
	);

	$options[] = array(
		'name' => __('Vimeo', 'icy'),
		'desc' => __('', 'icy'),
		'id' => 'vimeo',
		'std' => '',
		'type' => 'text'
	);

	$options[] = array(
		'name' => __('Flickr', 'icy'),
		'desc' => __('', 'icy'),
		'id' => 'flickr',
		'std' => '',
		'type' => 'text'
	);

	$options[] = array(
		'name' => __('Pinterest', 'icy'),
		'desc' => __('', 'icy'),
		'id' => 'pinterest',
		'std' => '',
		'type' => 'text'
	);

	$options[] = array(
		'name' => __('LinkedIn', 'icy'),
		'desc' => __('', 'icy'),
		'id' => 'linkein',
		'std' => '',
		'type' => 'text'
	);

	$options[] = array(
		'name' => __('Tumblr', 'icy'),
		'desc' => __('', 'icy'),
		'id' => 'tumblr',
		'std' => '',
		'type' => 'text'
	);

	$options[] = array(
		'name' => __('RSS', 'icy'),
		'desc' => __('', 'icy'),
		'id' => 'rss',
		'std' => '',
		'type' => 'text'
	);

	/*
	 * SNIPPETS
	 */
	
	$options[] = array(
		'name' => __('Snippets', 'icy'),
		'type' => 'heading',
		'icon' => 'icon-th-list'
	);
	
	$options[] = array(
		'name' => __('Post Info', 'icy'),
		'desc' => __('Data above the content of blog post.', 'icy'),
		'id' => 'post_info',
		'std' => '[post_date] [post_author before=""] [post_comments before=""] [post_edit before=""]',
		'type' => 'text'
	);
	
	$options[] = array(
		'name' => __('Post Meta', 'icy'),
		'desc' => __('Data below each blog post.', 'icy'),
		'id' => 'post_meta',
		'std' => '[post_categories before="" after=""] [post_tags before="" after=""]',
		'type' => 'text'
	);
	
	$options[] = array(
		'name' => __('Footer Content', 'icy'),
		'desc' => __('Footer content. Below widget area.', 'icy'),
		'id' => 'footer_content',
		'std' => "<div id=\"copyright\">[footer_copyright]</div>\n<div id=\"credit\">\n   Powered by [footer_wordpress_link].\n   Design by [footer_wildweblab_link]\n</div>",
		'type' => 'textarea'
	);

	$options[] = array(
		'name' => __('Header Scripts', 'icy'),
		'desc' => __('Enter scripts or code you would like output to wp_head().', 'icy'),
		'id' => 'header_scripts',
		'std' => '',
		'type' => 'textarea'
	);
	
	$options[] = array(
		'name' => __('Footer Scripts', 'icy'),
		'desc' => __('Enter scripts or code you would like output to wp_footer().', 'icy'),
		'id' => 'footer_scripts',
		'std' => '',
		'type' => 'textarea'
	);
	
	/*
	 * STYLING
	 */

	$options[] = array(
		'name' => __('Styling', 'icy'),
		'type' => 'heading',
		'icon' => 'icon-eye'
	);

	$options[] = array(
		'name' => __('Hide Post Format Icons', 'icy'),
		'desc' => __('', 'icy'),
		'id' => 'hide_post_format_icons',
		'std' => array( 'enabled' => 0 ),
		'type' => 'multicheck',
		'options' => array(
			'enabled' => 'Check To Hide',
		)
	);

	$options['header_color'] = array(
		'name' => __('Header Background', 'icy'),
		'desc' => __('Pick a custom background color for header.', 'icy'),
		'id' => 'header_color',
		'std' => '#2185c5',
		'type' => 'color' 
	);

	$options['link_color'] = array(
		'name' => __('Link Color', 'icy'),
		'desc' => __('Pick a custom color for links.', 'icy'),
		'id' => 'link_color',
		'std' => '#2185c5',
		'type' => 'color' 
	);
	
	$options['link_hover_color'] = array(
		'name' => __('Link Hover Color', 'icy'),
		'desc' => __('Pick a custom color for hover links.', 'icy'),
		'id' => 'link_hover_color',
		'std' => '#236688',
		'type' => 'color' 
	);

	$options[] = array(
		'name' => __('Custom CSS', 'icy'),
		'desc' => __('Add custom CSS code.', 'icy'),
		'id' => 'custom_css',
		'std' => '',
		'type' => 'textarea'
	);

	return $options;
}


/**
 * Refresh changes in real time.
 *
 * @since 1.0
 */
function optionsframework_custom_scripts() { 
	?>
	<script type="text/javascript">
	jQuery(document).ready(function($) {
		$('#example_showhidden').click(function() {
			$('#section-example_text_hidden').fadeToggle(400);
		});

		if ($('#example_showhidden:checked').val() !== undefined) {
			$('#section-example_text_hidden').show();
		}
	});
	</script>
	<?php
}
add_action('optionsframework_custom_scripts', 'optionsframework_custom_scripts');


/**
 * Override default filter for 'textarea' sanitization.
 *
 * @since 1.0
 *
 * @uses wwl_custom_sanitize_textarea() New sanitization rules
 */ 
function wwl_change_santiziation() {
    remove_filter( 'of_sanitize_textarea', 'of_sanitize_textarea' );
    add_filter( 'of_sanitize_textarea', 'wwl_custom_sanitize_textarea' );
}
add_action('admin_init', 'wwl_change_santiziation', 100);


/**
 * New sanitization rules for textarea.
 * 
 * @since 1.0
 */
function wwl_custom_sanitize_textarea( $input ) {
    global $allowedposttags;
	
    $custom_allowedtags["embed"] = array(
		"src" => array(),
		"type" => array(),
		"allowfullscreen" => array(),
		"allowscriptaccess" => array(),
		"height" => array(),
		"width" => array()
	);
	
	$custom_allowedtags["script"] = array('src' => array(), 'type' => array());
	$custom_allowedtags["link"] = array('href' => array(), 'rel' => array(), 'type' => array(), 'media' => array());
	$custom_allowedtags["a"] = array('href' => array(),'title' => array());
	$custom_allowedtags["img"] = array('src' => array(),'title' => array(),'alt' => array());
	$custom_allowedtags["br"] = array();
	$custom_allowedtags["em"] = array();
	$custom_allowedtags["strong"] = array();
	$custom_allowedtags["div"] = array();

	$custom_allowedtags = array_merge( $custom_allowedtags, $allowedposttags );

    return wp_kses( $input, $custom_allowedtags );
}
