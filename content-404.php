<?php 
/**
 * Content for 404 pages (Not Found).
 * 
 * @author WildWebLab
 * @link   http://wildweblab.com/theme/icy
 */
?><article id="post-0" class="post hentry error404 not-found">
	<header class="entry-header">
		<h1 class="entry-title"><?php _e( '404! That page can&rsquo;t be found.', 'icy' ); ?></h1>
	</header>

	<div class="entry-content">
		<p><?php _e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'icy' ); ?></p>
		
		<div class="widget space-bot">
			<?php get_search_form(); ?>
		</div>
		
		<?php the_widget( 'WP_Widget_Recent_Posts', '', array( 'before_title' => '<h3 class="widget-title">', 'after_title' => '</h3>' ) ); ?>
		
		<div class="row">
			<div class="widget span6">
				<h3 class="widget-title"><?php _e( 'Categories', 'icy' ); ?></h3>
				<ul>
					<?php wp_list_categories( array( 'orderby' => 'count', 'order' => 'DESC', 'show_count' => 1, 'title_li' => '', 'number' => 10 ) ); ?>
				</ul>
				
			</div>

			<?php the_widget( 'WP_Widget_Tag_Cloud', '', array( 'before_widget' => '<div class="widget span6">', 'before_title' => '<h3 class="widget-title">', 'after_title' => '</h3>' ) ); ?>
		</div>
	</div>
</article>