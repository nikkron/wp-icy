<?php
/**
 * The template part for displaying a message that posts cannot be found.
 * 
 * @author WildWebLab
 * @link   http://wildweblab.com/theme/icy
 */
?>
<article id="post-0" class="post hentry no-results not-found">
	<div class="entry-content">
		<?php if ( is_home() ) : ?>

			<p><?php printf( __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'icy' ), admin_url( 'post-new.php' ) ); ?></p>

		<?php elseif ( is_search() ) : ?>

			<p><?php _e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'icy' ); ?></p>
			<?php get_search_form(); ?>

		<?php else : ?>

			<p><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'icy' ); ?></p>
			<?php get_search_form(); ?>

		<?php endif; ?>
	</div>
</article>
