<?php
/*
Description: A framework for building theme options.
Author: Devin Price
Author URI: http://www.wptheming.com
License: GPLv2
*/


/* Make sure we don't expose any info if called directly */
if ( !function_exists( 'add_action' ) ) {
	echo "Hi there! I'm just a little extension, don't mind me.";
	exit;
}

/* If the user can't edit theme options, no use running this plugin */

add_action('init', 'optionsframework_rolescheck' );

function optionsframework_rolescheck () {
	if ( current_user_can( 'edit_theme_options' ) ) {
		// If the user can edit theme options, let the fun begin!
		add_action( 'admin_menu', 'optionsframework_add_page');
		add_action( 'admin_init', 'optionsframework_init' );
		add_action( 'admin_init', 'optionsframework_mlu_init' );
		add_action( 'wp_before_admin_bar_render', 'optionsframework_adminbar' );
	}
}

/* Loads the file for option sanitization */

add_action('init', 'optionsframework_load_sanitization' );

function optionsframework_load_sanitization() {
	locate_template( OPTIONS_FRAMEWORK_DIRECTORY . 'options-sanitize.php', true );
}


/* 
 * Creates the settings in the database by looping through the array
 * we supplied in options.php.  This is a neat way to do it since
 * we won't have to save settings for headers, descriptions, or arguments.
 *
 * Read more about the Settings API in the WordPress codex:
 * http://codex.wordpress.org/Settings_API
 *
 */

function optionsframework_init() {
	// Include the required files
	locate_template( OPTIONS_FRAMEWORK_DIRECTORY . 'options-interface.php', true );
	locate_template( OPTIONS_FRAMEWORK_DIRECTORY . 'options-medialibrary-uploader.php', true );
	
	// Loads the options array from the theme
	locate_template( WWL_LIB . 'theme-options.php', true );

	$optionsframework_settings = get_option('optionsframework');
	
	// Updates the unique option id in the database if it has changed
	optionsframework_option_name();
	
	// Gets the unique id, returning a default if it isn't defined
	if ( isset($optionsframework_settings['id']) ) {
		$option_name = $optionsframework_settings['id'];
	}
	else {
		$option_name = 'optionsframework';
	}
	
	// If the option has no saved data, load the defaults
	if ( ! get_option( $optionsframework_settings['id'] ) ) {
		optionsframework_setdefaults();
	}
	
	// Registers the settings fields and callback
	register_setting( 'optionsframework', $option_name, 'optionsframework_validate' );
	
	// Change the capability required to save the 'optionsframework' options group.
	add_filter( 'option_page_capability_optionsframework', 'optionsframework_page_capability' );

	if ( isset( $_GET['activated'] ) ) {
		wp_redirect( admin_url("themes.php?page=theme-options"), 302 ); 
		exit;
	}
}

/**
 * Ensures that a user with the 'edit_theme_options' capability can actually set the options
 * See: http://core.trac.wordpress.org/ticket/14365
 *
 * @param string $capability The capability used for the page, which is manage_options by default.
 * @return string The capability to actually use.
 */

function optionsframework_page_capability( $capability ) {
	return 'edit_theme_options';
}

/* 
 * Adds default options to the database if they aren't already present.
 * May update this later to load only on plugin activation, or theme
 * activation since most people won't be editing the options.php
 * on a regular basis.
 *
 * http://codex.wordpress.org/Function_Reference/add_option
 *
 */

function optionsframework_setdefaults() {
	
	$optionsframework_settings = get_option('optionsframework');

	// Gets the unique option id
	$option_name = $optionsframework_settings['id'];
	
	/* 
	 * Each theme will hopefully have a unique id, and all of its options saved
	 * as a separate option set.  We need to track all of these option sets so
	 * it can be easily deleted if someone wishes to remove the plugin and
	 * its associated data.  No need to clutter the database.  
	 *
	 */
	
	if ( isset($optionsframework_settings['knownoptions']) ) {
		$knownoptions =  $optionsframework_settings['knownoptions'];
		if ( !in_array($option_name, $knownoptions) ) {
			array_push( $knownoptions, $option_name );
			$optionsframework_settings['knownoptions'] = $knownoptions;
			update_option('optionsframework', $optionsframework_settings);
		}
	} else {
		$newoptionname = array($option_name);
		$optionsframework_settings['knownoptions'] = $newoptionname;
		update_option('optionsframework', $optionsframework_settings);
	}
	
	// Gets the default options data from the array in options.php
	$options = optionsframework_options();
	
	// If the options haven't been added to the database yet, they are added now
	$values = of_get_default_values();
	
	if ( isset($values) ) {
		add_option( $option_name, $values ); // Add option with default settings
	}
}

/* Add a subpage called "Theme Options" to the appearance menu. */

if ( !function_exists( 'optionsframework_add_page' ) ) {

	function optionsframework_add_page() {
		global $my_admin_page;

		$my_admin_page = add_theme_page( 
			__( 'Theme Options', 'icy' ), 
			__( 'Theme Options', 'icy' ), 
			'manage_options', 
			'theme-options', 
			'optionsframework_settings_page'
		);
		
		// Load the help tab
		// add_action( 'load-' . $my_admin_page, 'optionsframework_help_tab' );

		// Load the required CSS and javscript
		add_action( 'admin_enqueue_scripts', 'optionsframework_load_scripts' );
		add_action( 'admin_enqueue_scripts', 'optionsframework_load_styles' );
	}
	
}

/* Loads the CSS */


function optionsframework_load_styles() {
	wp_enqueue_style('optionsframework', OPTIONS_FRAMEWORK_URL . 'css/optionsframework.css?4');
	wp_enqueue_style('color-picker', OPTIONS_FRAMEWORK_URL . 'css/colorpicker.css');
}	

/* Loads the javascript */

function optionsframework_load_scripts($hook) {

	//if ( 'appearance_page_options-framework' != $hook )
     //   return;
	
	// Enqueued scripts
	wp_enqueue_script('jquery-ui-core');
	wp_enqueue_script('color-picker', OPTIONS_FRAMEWORK_URL . 'js/colorpicker.js', array('jquery'));
	wp_enqueue_script('options-custom', OPTIONS_FRAMEWORK_URL . 'js/options-custom.js?4', array('jquery'));
	
	// Inline scripts from options-interface.php
	add_action('admin_head', 'of_admin_head');
}

function of_admin_head() {

	// Hook to add custom scripts
	do_action( 'optionsframework_custom_scripts' );
}


/* 
 * Builds out the options panel.
 *
 * If we were using the Settings API as it was likely intended we would use
 * do_settings_sections here.  But as we don't want the settings wrapped in a table,
 * we'll call our own custom optionsframework_fields.  See options-interface.php
 * for specifics on how each individual field is generated.
 *
 * Nonces are provided using the settings_fields()
 *
 */
function optionsframework_settings_page() {
	$docs_url = 'http://wildweblab.com/docs/icy';

	?>
	<div id="wwl-admin-wrap">
	<?php settings_errors(); ?>
	<?php optionsframework_upgrade_info(); ?>
	<form action="options.php" enctype="multipart/form-data" method="post">
		<div id="wwl-admin-header">
			<?php optionsframework_themeinfo(); ?>
			<ul id="wwl-admin-help">
				<li><a href="<?php echo $docs_url; ?>" target="_blank"><i class="icon-lifebuoy"></i> <?php _e( 'Documentation', 'icy' ); ?></a></li>
			</ul>
			<input type="submit" class="button-primary" name="update" value="<?php esc_attr_e( 'Save Settings', 'icy' ); ?>" />
			<div class="clear"></div>
		</div>
		<div id="wwl-admin-main">
			<?php optionsframework_tabs(); ?>
			<div id="wwl-admin-content">
				<div id="wwl-admin">
					<?php settings_fields('optionsframework'); ?>
					<?php optionsframework_fields(); /* Settings */ ?>
					<?php optionsframework_importexport(); ?>
				</div>
			</div>
			<div class="clear"></div>
		</div>
		<div id="wwl-admin-footer">
			<input type="submit" class="button-primary" name="update" value="<?php esc_attr_e( 'Save Settings', 'icy' ); ?>" />
			<input type="submit" class="reset-button button-secondary" name="reset" value="<?php esc_attr_e( 'Restore Defaults', 'icy' ); ?>" onclick="return confirm( '<?php print esc_js( __( 'Click OK to reset. Any theme settings will be lost!', 'icy' ) ); ?>' );" />
			<div class="clear"></div>
		</div>
	</form>
	</div>
	<?php
}


/**
 * Validate Options.
 *
 * This runs after the submit/reset button has been clicked and
 * validates the inputs.
 *
 * @uses $_POST['reset'] to restore default options
 */
function optionsframework_validate( $input ) {
	if( isset( $_POST['export_settings'] ) ) {
		$theme = wp_get_theme();

		header('Cache-Control: public, must-revalidate');
		header('Pragma: hack');
		header('Content-Type: text/plain');
		header( 'Content-Disposition: attachment; filename="' . $theme->Name . '-Settings.json"' );						
		
		$config = get_option( 'optionsframework' );

		if ( ! isset( $config['id'] ) ) {
			return false;
		}

		echo json_encode( get_option( $config['id'] ) );
		exit();
	} elseif ( isset( $_POST['reset'] ) ) {
	/*
	 * Restore Defaults.
	 *
	 * In the event that the user clicked the "Restore Defaults"
	 * button, the options defined in the theme's options.php
	 * file will be added to the option for the active theme.
	 */
		
		add_settings_error( 'options-framework', 'restore_defaults', __( 'Default options restored.', 'icy' ), 'updated fade' );
		return of_get_default_values();
	} else {
	
	/*
	 * Update Settings
	 *
	 * This used to check for $_POST['update'], but has been updated
	 * to be compatible with the theme customizer introduced in WordPress 3.4
	 */
		
		if( isset( $_POST['import_settings'] ) ) {
			if( is_uploaded_file( $_FILES['file']['tmp_name'] ) && end( explode( ".", $_FILES['file']['name'] ) ) == 'json' ) {
				$method = '';
				$form_fields = array( 'file', 'import_settings' );

				$file = wp_handle_upload( $_FILES['file'], array('test_form' => false, 'test_type' => false) );
				
				$url = wp_nonce_url('themes.php?page=theme-options','wwl-admin-import');
				
				if( false === ( $creds = request_filesystem_credentials( $url, $method, false, false, $form_fields ) ) ) {
				    return false;
				}

				if( ! WP_Filesystem( $creds ) ) {
					request_filesystem_credentials( $url, $method, true, false, $form_fields );
					return false;
				}

				global $wp_filesystem;

				$file_content = $wp_filesystem->get_contents($file['file']);

				$wp_filesystem->delete($file['file']);

				$input = json_decode( $file_content, true );

				add_settings_error( 'options-framework', 'import_settings', __( 'Settings have been successfully imported.', 'icy' ), 'updated fade' );
			} else {
				add_settings_error( 'options-framework', 'import_settings', __( 'Could not read your file.', 'icy' ), 'error fade' );
			}
		} else {
			add_settings_error( 'options-framework', 'save_options', __( 'Settings saved.', 'icy' ), 'updated fade' );
		}


		$clean = array();
		$options = optionsframework_options();
		foreach ( $options as $option ) {

			if ( ! isset( $option['id'] ) ) {
				continue;
			}

			if ( ! isset( $option['type'] ) ) {
				continue;
			}

			$id = preg_replace( '/[^a-zA-Z0-9._\-]/', '', strtolower( $option['id'] ) );

			// Set checkbox to false if it wasn't sent in the $_POST
			if ( 'checkbox' == $option['type'] && ! isset( $input[$id] ) ) {
				$input[$id] = false;
			}

			// Set each item in the multicheck to false if it wasn't sent in the $_POST
			if ( 'multicheck' == $option['type'] && ! isset( $input[$id] ) ) {
				foreach ( $option['options'] as $key => $value ) {
					$input[$id][$key] = false;
				}
			}

			// For a value to be submitted to database it must pass through a sanitization filter
			if ( has_filter( 'of_sanitize_' . $option['type'] ) ) {
				$clean[$id] = apply_filters( 'of_sanitize_' . $option['type'], $input[$id], $option );
			}
		}

		return $clean;
	}

}

/**
 * Format Configuration Array.
 *
 * Get an array of all default values as set in
 * options.php. The 'id',lstd' and 'type' keys need
 * to be defined in the configuration array. In the
 * event that these keys are not present the option
 * will not be included in this function's output.
 *
 * @return    array     Rey-keyed options configuration array.
 *
 * @access    private
 */
 
function of_get_default_values() {
	$output = array();
	$config = optionsframework_options();
	foreach ( (array) $config as $option ) {
		if ( ! isset( $option['id'] ) ) {
			continue;
		}
		if ( ! isset( $option['std'] ) ) {
			continue;
		}
		if ( ! isset( $option['type'] ) ) {
			continue;
		}
		if ( has_filter( 'of_sanitize_' . $option['type'] ) ) {
			$output[$option['id']] = apply_filters( 'of_sanitize_' . $option['type'], $option['std'], $option );
		}
	}
	return $output;
}



/**
 * Get Option.
 *
 * Helper function to return the theme option value.
 * If no value has been saved, it returns $default.
 * Needed because options are saved as serialized strings.
 */
	 
function of_get_option( $name, $default = false ) {
	$config = get_option( 'optionsframework' );

	if ( ! isset( $config['id'] ) ) {
		return $default;
	}

	$options = get_option( $config['id'] );

	if ( isset( $options[$name] ) ) {
		return $options[$name];
	}

	return $default;
}


/**
 * Add Theme Options menu item to Admin Bar.
 */

function optionsframework_adminbar() {

	global $wp_admin_bar;

	$wp_admin_bar->add_menu( array(
			'parent' => 'appearance',
			'id' => 'of_theme_options',
			'title' => __( 'Theme Options', 'icy' ),
			'href' => admin_url( 'themes.php?page=theme-options' )
		));
}


function wwl_hide_welcome_message() {
	update_user_meta( get_current_user_id(), 'wwl_welcome_message_hidden', 'true' );
	exit;
}
add_action( 'wp_ajax_wwl_hide_welcome_message', 'wwl_hide_welcome_message' );