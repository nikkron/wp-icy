<?php 
/**
 * The template for displaying the search form.
 * 
 * @author WildWebLab
 * @link   http://wildweblab.com/theme/icy
 */
?>
<form role="search" method="get" class="search-form" action="<?php echo esc_attr( home_url('/') ); ?>">
	<input type="text" value="" name="s" class="s query" placeholder="<?php _e('Search', 'icy'); ?>">
	<button type="submit" class="search-submit"><i class="icon-search"></i></button>
	<div class="clearfix"></div>
</form>