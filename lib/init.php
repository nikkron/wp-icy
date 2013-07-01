<?php
/**
 * Initializes the theme.
 * 
 * @author WildWebLab
 * @link   http://wildweblab.com/theme/icy
 */


/**
 * Define default constans used in the theme.
 * 
 * @since 1.0
 */
function wwl_constants() {
	define( 'WWL_LIB', 'lib/' );
	define( 'WWL_ADMIN_IMG_URL', get_template_directory_uri() . '/lib/admin/img/' );
	define( 'OPTIONS_FRAMEWORK_URL', get_template_directory_uri() . '/lib/admin/' );
	define( 'OPTIONS_FRAMEWORK_DIRECTORY', WWL_LIB . 'admin/' );

	define( 'WWL_SETTINGS_ID', 'icy_theme_options' );
}
add_action( 'wwl_init', 'wwl_constants' );


/**
 * Load all the theme files.
 *
 * @since 1.0
 */
function wwl_load() {
	locate_template( OPTIONS_FRAMEWORK_DIRECTORY . 'options-framework.php', true );
	locate_template( WWL_LIB . 'core.php', true );
	locate_template( WWL_LIB . 'shortcodes.php', true );
	locate_template( WWL_LIB . 'widgets.php', true );
	locate_template( WWL_LIB . 'theme-options.php', true );
	locate_template( WWL_LIB . 'theme-customizer.php', true );
}
add_action( 'wwl_init', 'wwl_load' );


do_action( 'wwl_init' ); // Hook

