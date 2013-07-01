<?php 
/**
 * The sidebar containing the main widget area.
 * 
 * @author WildWebLab
 * @link   http://wildweblab.com/theme/icy
 */

		do_action( 'wwl_close_content' ); // Hook 
		?>
	</div> <!-- #content -->
	<?php 

	do_action( 'wwl_after_content' ); // Hook 

	if ( wwl_is_active_sidebar('primary') )
		get_template_part( 'sidebar', 'primary' ); 
		
	?>
</div> <!-- #content-sidebar -->
