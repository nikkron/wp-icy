<?php
/**
 * Include core functions of the theme. 
 * WARNING: Do NOT remove.
 */
locate_template( 'lib/init.php', true );


// Set the content width based on the theme's design and stylesheet.
if ( ! isset( $content_width ) )
	$content_width = 580;


/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * @since 1.0
 */
function icy_setup() {
	// Add default posts and comments RSS feed links to head
	add_theme_support( 'automatic-feed-links' );

	//This theme styles the visual editor to resemble the theme style
	add_editor_style( 'assets/css/editor-style.css' );

	// Add support for thumbnails
	add_theme_support( 'post-thumbnails' );

	// Add new thumbnail size
	add_image_size( 'wwl-large', 620, 250, true );

	// Custom header image
	add_theme_support( 'custom-header', array(
		'default-image' => get_template_directory_uri() . '/assets/img/icy-logo.png',
		'random-default' => false,
		'width' => '65',
		'height' => '55',
		'default-text-color' => 'fff',
		'flex-height' => true,
		'flex-width' => true,
		'header-text' => true,
		'uploads' => true,
		'wp-head-callback' => 'wwl_header_style',
		'admin-head-callback' => 'wwl_admin_header_style',
		'admin-preview-callback' => 'wwl_admin_header_image',
	) );

	// Register the available menus
	register_nav_menus( array(
		'primary' => __( 'Primary Navigation', 'icy' ),
	));

	//Add support for Post Formats
	add_theme_support( 'post-formats', array( 'aside', 'gallery', 'image', 'audio', 'video', 'status', 'quote', 'link', 'chat' ) );

	/**
	 *	Make theme available for translation
	 *	Translations can be filed in the /languages/ directory
	 */ 
	load_theme_textdomain( 'icy', get_template_directory() . '/languages' );
}
add_action( 'after_setup_theme', 'icy_setup' );


/**
 * Enqueue scripts and styles for front-end.
 *
 * @since 1.0
 */
function icy_scripts_styles() {	
	//Load Google Fonts
	$fonts_url = icy_fonts_url();
	if ( ! empty( $fonts_url ) )
		wp_enqueue_style( 'icy-fonts', esc_url_raw( $fonts_url ), array(), null );

	//Load CSS files
	wp_enqueue_style( 'icy-style', get_stylesheet_uri() );
	
	//Load Font with Icons
	wp_enqueue_style( 'icy-icons', get_template_directory_uri() . '/assets/font/icy-icons.css' );

	//Load JavaScript files.
	wp_enqueue_script( 'icy-superfish', get_template_directory_uri() . '/assets/js/superfish.js', array('jquery') );
	wp_enqueue_script( 'icy-main', get_template_directory_uri() . '/assets/js/main.js', array('jquery') );
}
add_action( 'wp_enqueue_scripts', 'icy_scripts_styles' );


/**
 * Adds additional stylesheets to the TinyMCE editor if needed.
 * 
 * @since 1.0
 * 
 * @uses icy_fonts_url() to get the Google Font stylesheet URL.
 * @param string $mce_css CSS path to load in TinyMCE.
 * @return string
 */
function icy_mce_css( $mce_css ) {
	$fonts_url = icy_fonts_url();

	if ( empty( $fonts_url ) )
		return $mce_css;

	if ( ! empty( $mce_css ) )
		$mce_css .= ',';

	$mce_css .= esc_url_raw( str_replace( ',', '%2C', $fonts_url ) );

	return $mce_css;
}
add_filter( 'mce_css', 'icy_mce_css' );


/**
 * Returns the Google font stylesheet URL, if available.
 *
 * The use of Source Sans Pro and Oxygen by default is localized. For languages
 * that use characters not supported by the font, the font can be disabled.
 *
 * @since 1.0
 *
 * @return string Font stylesheet or empty string if disabled.
 */
function icy_fonts_url() {
	$fonts_url = '';

	$font_families = array();

	$font_families[] = 'Source+Sans+Pro:400,700,300italic,400italic,700italic';

	$font_families[] = 'Oxygen:400,300';

	$protocol = is_ssl() ? 'https' : 'http';
	
	$query_args = array(
		'family' => implode( '|', $font_families ),
		'subset' => 'latin,latin-ext',
	);
	
	$fonts_url = add_query_arg( $query_args, "$protocol://fonts.googleapis.com/css" );

	return $fonts_url;
}


/**
 * Add JavaScript to pages with the comment form to support
 * sites with threaded comments (when in use).
 *
 * @since 1.0
 */
function icy_comment_reply_script() {
	if ( comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'comment_form_before', 'icy_comment_reply_script' );


/**
 * Output IE conditional html5 shim in the head tag.
 *
 * @since 1.0
 */
function icy_html5_shim() {
    global $is_IE;
	
    if ( $is_IE ) {
    ?>
		<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
	<?php
    }
}
add_action( 'wp_print_scripts', 'icy_html5_shim' );


/** 
 * Add Viewport meta tag for mobile browsers.
 *
 * @since 1.0
 */
function icy_viewport_meta_tag() {
    echo "<meta name=\"viewport\" content=\"width=device-width, initial-scale=1\" />\n";
}
add_action( 'wp_head', 'icy_viewport_meta_tag', 1 );


/**
 * Register widgetized areas, including two sidebars and four widget-ready columns in the footer.
 *
 * @since 1.0
 * 
 * @uses register_sidebar
 */
function icy_widgets_init() {
	// Area 1, located at the top of the sidebar.
	register_sidebar( array(
		'name' => __( 'Sidebar', 'icy' ),
		'id' => 'primary-widget-area',
		'description' => __( '', 'icy' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget' => '</section>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	
	// Area 2, located in the header. Empty by default.
	register_sidebar( array(
		'name' => __( 'Header Right', 'icy' ),
		'id' => 'header-widget-area',
		'description' => __( 'This is the widget area in the header.', 'icy' ),
		'before_widget' => '<div class="widget-content"> ',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	
	// Area 3, located in the footer. Empty by default.
	register_sidebar( array(
		'name' => __( 'Footer 1', 'icy' ),
		'id' => '1-footer-widget-area',
		'description' => __( 'The first footer widget area', 'icy' ),
		'before_widget' => '<div class="%1$s widget">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	
	// Area 4, located in the footer. Empty by default.
	register_sidebar( array(
		'name' => __( 'Footer 2', 'icy' ),
		'id' => '2-footer-widget-area',
		'description' => __( 'The second footer widget area', 'icy' ),
		'before_widget' => '<div class="%1$s widget">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	
	// Area 5, located in the footer. Empty by default.
	register_sidebar( array(
		'name' => __( 'Footer 3', 'icy' ),
		'id' => '3-footer-widget-area',
		'description' => __( 'The third footer widget area', 'icy' ),
		'before_widget' => '<div class="%1$s widget">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	
	// Area 6, located in the footer. Empty by default.
	register_sidebar( array(
		'name' => __( 'Footer 4', 'icy' ),
		'id' => '4-footer-widget-area',
		'description' => __( 'The fourth footer widget area', 'icy' ),
		'before_widget' => '<div class="%1$s widget">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
}
add_action( 'widgets_init', 'icy_widgets_init' );