<?php 
/**
 * The template used for displaying page content in page.php.
 * 
 * @author WildWebLab
 * @link   http://wildweblab.com/theme/icy
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php do_action( 'wwl_before_post_title' ); // Hook ?>
		<h1 class="entry-title"><?php the_title(); ?></h1>
		<?php do_action( 'wwl_after_post_title' ); // Hook ?>
	</header>
	
	<?php do_action( 'wwl_before_post_content' ); // Hook ?>
	
	<div class="entry-content">
		<?php the_content(); ?>
		<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'icy' ), 'after' => '</div>' ) ); ?>
	</div>
	<div class="clearfix"></div>
	
	<?php do_action( 'wwl_after_post_content' ); // Hook ?>
</article>

