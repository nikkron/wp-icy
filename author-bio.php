<?php
/**
 * The template for displaying Author bios.
 * 
 * @author WildWebLab
 * @link   http://wildweblab.com/theme/icy
 */
?>
<div class="author-info">
	<div class="author-avatar">
		<?php echo get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'twentythirteen_author_bio_avatar_size', 74 ) ); ?>
	</div>
	<div class="author-description">
		<h2 class="author-title"><?php printf( __( 'About %s', 'icy' ), get_the_author() ); ?></h2>
		<p class="author-bio">
			<?php the_author_meta( 'description' ); ?>
			<a class="author-link" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author">
				<?php printf( __( 'View all posts by %s <span class="meta-nav">&rarr;</span>', 'icy' ), get_the_author() ); ?>
			</a>
		</p>
	</div>
</div>