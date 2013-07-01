<?php 
/**
 * The template for displaying Comments.
 *
 * The area of the page that contains both current comments
 * and the comment form. The actual display of comments is
 * handled by a callback to wwl_comment() which is
 * located in the lib/core.php file.
 * 
 * @author WildWebLab
 * @link   http://wildweblab.com/theme/icy
 */


if ( post_password_required() )
	return;
?>

<div id="comments" class="comments-area">
	<?php if ( have_comments() ) : ?>
		<h2 class="comments-title">
			<?php
				printf( _n( 'One Comment', '%1$s Comments', get_comments_number(), 'icy' ),
					number_format_i18n( get_comments_number() ) );
			?>
		</h2>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
		<div id="comment-nav-above" class="site-navigation comment-navigation">
			<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'icy' ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'icy' ) ); ?></div>
			<div class="clearfix"></div>
		</div>
		<?php endif; // check for comment navigation ?>

		<ol class="commentlist">
			<?php wp_list_comments( array( 'callback' => 'wwl_comment' ) ); ?>
		</ol>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
		<div id="comment-nav-below" class="site-navigation comment-navigation">
			<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'icy' ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'icy' ) ); ?></div>
			<div class="clearfix"></div>
		</div>
		<?php endif; // check for comment navigation ?>

	<?php endif; // have_comments() ?>

	<?php
		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( ! comments_open() && '0' != get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
	?>
		<p class="nocomments"><?php _e( 'Comments are closed.', 'icy' ); ?></p>
	<?php endif; ?>

<?php

$req = get_option( 'require_name_email' );
$field = '<p><input class="text-input" type="text" name="%1$s" id="%1$s" value="%3$s" size="22" tabindex="%4$d" /><label for="%1$s" class="comment-field">%2$s</label></p>';

comment_form( array(
	'comment_field' => '<textarea id="comment" name="comment" cols="50" rows="10" aria-required="true" tabindex="4"></textarea>',
	'comment_notes_before' => '',
	'comment_notes_after' => '',
	'fields' => array(
		'author' => sprintf(
			$field,
			'author',
			(
				$req ?
				__( 'Name <span>*</span>', 'icy' ) :
				__( 'Name:', 'icy' )
			),
			esc_attr( $comment_author ),
			1
		),
		'email' => sprintf(
			$field,
			'email',
			(
				$req ?
				__( 'Email <span>*</span>', 'icy' ) :
				__( 'Email:', 'icy' )
			),
			esc_attr( $comment_author_email ),
			2
		),
		'url' => sprintf(
			$field,
			'url',
			__( 'Website', 'icy' ),
			esc_attr( $comment_author_url ),
			3
		),
	),
	'label_submit' => __( 'Submit Comment', 'icy' ),
	'logged_in_as' => '<p class="com-logged-in">' . sprintf( __( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out &raquo;</a>', 'icy' ), admin_url( 'profile.php' ), $user_identity, wp_logout_url( apply_filters( 'the_permalink', get_permalink() ) ) ) . '</p>',
	'title_reply' => __( 'Leave a Reply', 'icy' ),
	'title_reply_to' => __( 'Leave a comment to %s', 'icy' ),
	'cancel_reply_link' => __( 'Click here to cancel reply.', 'icy' ),
) );

?>
</div>