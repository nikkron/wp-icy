<?php
/**
 * The template for displaying image attachments.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 * 
 * @author WildWebLab
 * @link   http://wildweblab.com/theme/icy
 */


get_header(); ?>

<?php do_action( 'wwl_before_loop' ); // Hook ?>

		<?php while ( have_posts() ) : the_post(); ?>

				<article id="post-<?php the_ID(); ?>" <?php post_class( 'image-attachment' ); ?>>
					<header class="entry-header">

						<div class="entry-info">
							<?php
								$metadata = wp_get_attachment_metadata();
								printf( __( '<span class="entry-date"><a href="%1$s" datetime="%2$s">%3$s</a></span> <a href="%4$s" title="Link to full-size image" class="full-size-link">%5$s &times; %6$s</a> <a href="%7$s" title="Return to %8$s" class="entry-categories" rel="gallery">%9$s</a>', 'icy' ),
									get_permalink(),
									esc_attr( get_the_date( 'c' ) ),
									esc_html( get_the_date() ),
									esc_url( wp_get_attachment_url() ),
									$metadata['width'],
									$metadata['height'],
									esc_url( get_permalink( $post->post_parent ) ),
									esc_attr( strip_tags( get_the_title( $post->post_parent ) ) ),
									get_the_title( $post->post_parent )
								);
							?>
							<?php edit_post_link( __( 'Edit', 'icy' ), '<span class="edit-link">', '</span>' ); ?>
						</div><!-- .entry-meta -->

						<h1 class="entry-title"><?php the_title(); ?></h1>

					</header><!-- .entry-header -->

					<div class="entry-content">

						<div class="entry-attachment">
							<div class="attachment">
<?php
/**
 * Grab the IDs of all the image attachments in a gallery so we can get the URL of the next adjacent image in a gallery,
 * or the first image (if we're looking at the last image in a gallery), or, in a gallery of one, just the link to that image file
 */
$attachments = array_values( get_children( array( 'post_parent' => $post->post_parent, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => 'ASC', 'orderby' => 'menu_order ID' ) ) );
foreach ( $attachments as $k => $attachment ) :
	if ( $attachment->ID == $post->ID )
		break;
endforeach;

$k++;
// If there is more than 1 attachment in a gallery
if ( count( $attachments ) > 1 ) :
	if ( isset( $attachments[ $k ] ) ) :
		// get the URL of the next image attachment
		$next_attachment_url = get_attachment_link( $attachments[ $k ]->ID );
	else :
		// or get the URL of the first image attachment
		$next_attachment_url = get_attachment_link( $attachments[ 0 ]->ID );
	endif;
else :
	// or, if there's only 1 image, get the URL of the image
	$next_attachment_url = wp_get_attachment_url();
endif;
?>
								<a href="<?php echo esc_url( $next_attachment_url ); ?>" title="<?php the_title_attribute(); ?>" rel="attachment"><?php
								$attachment_size = apply_filters( 'twentytwelve_attachment_size', array( 960, 960 ) );
								echo wp_get_attachment_image( $post->ID, $attachment_size );
								?></a>

								<?php if ( ! empty( $post->post_excerpt ) ) : ?>
								<div class="entry-caption">
									<?php the_excerpt(); ?>
								</div>
								<?php endif; ?>
							</div><!-- .attachment -->

						</div><!-- .entry-attachment -->

						<div class="entry-description">
							<?php the_content(); ?>
							<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'icy' ), 'after' => '</div>' ) ); ?>
						</div><!-- .entry-description -->
						
						<div class="clearfix"></div>

					</div><!-- .entry-content -->

				</article><!-- #post -->

				<div id="image-navigation" class="page-navigation">
					<span class="nav-previous"><?php previous_image_link( false, __( '&larr; Previous', 'icy' ) ); ?></span>
					<span class="nav-next"><?php next_image_link( false, __( 'Next &rarr;', 'icy' ) ); ?></span>
					<div class="clearfix"></div>
				</div>

				<?php comments_template(); ?>

			<?php endwhile; // end of the loop. ?>

	<?php do_action( 'wwl_after_loop' ); // Hook ?>

	</div> <!-- #content -->
</div> <!-- #content-sidebar --> 

<?php get_footer(); ?>