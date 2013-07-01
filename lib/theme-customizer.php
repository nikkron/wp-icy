<?php
/**
 * Add support for Theme Options in the Customizer.
 * 
 * @author WildWebLab
 * @link   http://wildweblab.com/theme/icy
 */


/**
 * Register customizer options.
 *
 * @since 1.0
 */
function icy_customize_register( $wp_customize ) {
	$options = optionsframework_options();

	$wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';
	
	
	/**
	 * Layout
	 */
	
	$wp_customize->add_section( 'layout', array(
		'title'          => __( 'Layout', 'icy' ),
		'priority'       => 40,
	));
	
	$wp_customize->add_setting( WWL_SETTINGS_ID . '[theme_layout]', array(
        'default' => $options['theme_layout']['std'],
        'type' => 'option'
    ) );
	
    $wp_customize->add_control( WWL_SETTINGS_ID . '_theme_layout', array(
        'label' => $options['theme_layout']['name'],
        'section' => 'layout',
        'settings' => WWL_SETTINGS_ID . '[theme_layout]',
        'type' => 'radio',
        'choices' => array(
			'cs' => 'Content on left',
			'sc' => 'Content on right',
			'c' => 'One-column, no sidebar',
		)
    ) );
}
add_action( 'customize_register', 'icy_customize_register' );

