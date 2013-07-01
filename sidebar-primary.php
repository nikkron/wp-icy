<?php 
/**
 * The primary sidebar.
 * 
 * @author WildWebLab
 * @link   http://wildweblab.com/theme/icy
 */


if ( is_active_sidebar( 'primary-widget-area' ) ) :

	do_action( 'wwl_before_sidebar_primary' ); //Hook

	?>
	<aside id="sidebar-primary" role="complementary">
		<?php 
		
		do_action( 'wwl_open_sidebar_primary' ); //Hook 
		
		dynamic_sidebar( 'primary-widget-area' ); 
		
		do_action( 'wwl_close_sidebar_primary' ); //Hook 
		
		?>
	</aside>
	<?php 

	do_action( 'wwl_after_sidebar_primary' ); //Hook

endif;