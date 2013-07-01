<?php
/**
 * Widgets for use in the theme.
 * 
 * @author WildWebLab
 * @link   http://wildweblab.com/theme/icy
 */


/**
 * Output social icons set in the theme options.
 * 
 * @since Icy 1.0
 */
class WWL_Social_Widget extends WP_Widget
{
	
	public function __construct()
	{
		parent::__construct(
			'wwl_social_widget',
			'WWL Social Icons',
			array( 'description' => __( 'Displays icons social icons set in theme options', 'icy' ), )
		);
	}

	public function widget( $args, $instance ) {
		extract( $args );
		$title = apply_filters( 'widget_title', $instance['title'] );
		
		echo $before_widget;

		if ( ! empty( $title ) )
			echo $before_title . $title . $after_title;

		wwl_social_icons();

		echo '<div class="clearfix"></div>';

		echo $after_widget;
	}

	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = strip_tags( $new_instance['title'] );

		return $instance;
	}

	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}
		else {
			$title = '';
		}
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'icy' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<?php 
	}
}
add_action( 'widgets_init', create_function( '', 'register_widget( "WWL_Social_Widget" );' ) );