<?php 
/**
 * The template for displaying posts in the Quote post format.
 * 
 * @author WildWebLab
 * @link   http://wildweblab.com/theme/icy
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<div class="post-format-indicator">
			<a class="entry-format" href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'icy' ), the_title_attribute( 'echo=0' ) ) ); ?>"><?php echo get_post_format_string( get_post_format() ); ?></a>
		</div>
		<?php do_action( 'wwl_before_post_title' ); // Hook ?>
		<?php do_action( 'wwl_after_post_title' ); // Hook ?>
	</header>
	<?php wwl_post_content(); ?>
</article>
