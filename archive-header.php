<?php 
/**
 * The template for displaying Archive header.
 * WARNING: It's disabled by default. Check archive.php
 * 
 * @author WildWebLab
 * @link   http://wildweblab.com/theme/icy
 */
?>
<header id="page-header">
	<h1 class="page-title">
	<?php
	if ( is_archive() ) {
	
		if ( is_category() ) {
		
			printf( __( 'Category Archives: %s', 'icy' ), '<span>' . single_cat_title( '', false ) . '</span>' );
			
		} elseif ( is_tag() ) {
		
			printf( __( 'Tag Archives: %s', 'icy' ), '<span>' . single_tag_title( '', false ) . '</span>' );

		} elseif ( is_author() ) {
			
			/* 
			 * Queue the first post, that way we know
			 * what author we're dealing with (if that is the case).
			 */
			the_post();
			
			printf( __( 'Author Archives: %s', 'icy' ), '<span class="vcard">' . get_the_author() . '</span>' );
			
			/* 
			 * Since we called the_post() above, we need to
			 * rewind the loop back to the beginning that way
			 * we can run the loop properly, in full.
			 */
			rewind_posts();

		} elseif ( is_day() ) {
		
			printf( __( 'Daily Archives: %s', 'icy' ), '<span>' . get_the_date() . '</span>' );

		} elseif ( is_month() ) {
		
			printf( __( 'Monthly Archives: %s', 'icy' ), '<span>' . get_the_date( 'F Y' ) . '</span>' );

		} elseif ( is_year() ) {
		
			printf( __( 'Yearly Archives: %s', 'icy' ), '<span>' . get_the_date( 'Y' ) . '</span>' );

		} else {
		
			_e( 'Archives', 'icy' );

		}
		
	} elseif ( is_search() ) {
	
		printf( __( 'Search Results for: %s', 'icy' ), get_search_query() );
		
	}
	?>
	</h1>
		
	<?php
	if ( is_category() ) {
		// show an optional category description
		$category_description = category_description();
			
		if ( ! empty( $category_description ) )
			echo apply_filters( 'category_archive_meta', '<div class="taxonomy-description">' . $category_description . '</div>' );
	} elseif ( is_tag() ) {
		// show an optional tag description
		$tag_description = tag_description();
		
		if ( ! empty( $tag_description ) )
			echo apply_filters( 'tag_archive_meta', '<div class="taxonomy-description">' . $tag_description . '</div>' );
	}
	?>
</header>