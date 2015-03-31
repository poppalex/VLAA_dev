<?php
/**
 * Video Widget
 *
 * @package GoodInc WordPress Theme
 * @since 1.0
*/
class wpex_video extends WP_Widget {

	//main construct
	function __construct() {
		
		// define widget class and description
		$widget_ops = array(
			'classname'	=> 'wpex-video-widget', 
			'description'	=> __( 'Embed a video using the WordPress built-in oEmbed function.', 'wpex' ),
		);
		
		
		// register the widget
		$this->WP_Widget('wpex_video', WPEX_THEME_BRANDING . ' - '. __( 'Video', 'wpex' ), $widget_ops);
		
	} // End construct
	
	

	// update the widget when new options have been entered
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['video_url'] = strip_tags($new_instance['video_url']);
		$instance['video_description'] = strip_tags($new_instance['video_description']);
		return $instance;
	}
	

	// print the widget option form on the widget management screen
	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => 'Video', 'id' => '', 'video_url' => '', 'video_description' => '' ) );
		$title = strip_tags($instance['title']);
		$video_url = strip_tags($instance['video_url']);
		$video_description = strip_tags($instance['video_description']); ?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>">
			<?php _e('Title:', 'wpex'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('video_url'); ?>">
			<?php _e('Video URL ', 'wpex'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('video_url'); ?>" name="<?php echo $this->get_field_name('video_url'); ?>" type="text" value="<?php echo esc_attr($video_url); ?>" />
			<span style="display:block;padding:5px 0" class="description"><?php _e('Enter in a video URL that is compatible with WordPress\'s built-in oEmbed feature.', 'wpex'); ?> <a href="http://codex.wordpress.org/Embeds" target="_blank"><?php _e('Learn More', 'wpex'); ?></a></span>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('video_description'); ?>">
			<?php _e('Description', 'wpex'); ?></label>
			<textarea rows="5" class="widefat" id="<?php echo $this->get_field_id('video_description'); ?>" name="<?php echo $this->get_field_name('video_description'); ?>" type="text"><?php echo stripslashes($instance['video_description']); ?></textarea>
		</p>
		
	<?php }
	
	
	// display the widget in the theme
	function widget($args, $instance) {
		extract( $args );
		
		//before widget hook
		echo $before_widget;
		
		//show widget title
		$title = apply_filters( 'widget_title', $instance['title'] );
		if ( $title )
			echo $before_title . $title . $after_title;
		
		// define video height and width
		$video_size = array(
			'width' => 270
		);
		
		// show video
		if( $instance['video_url'] )  { echo '<div class="wpex-fitvids">' . wp_oembed_get( $instance['video_url'], $video_size ) . '</div>';
		} else {  _e('You forgot to enter a video URL.', 'wpex' ); }
		
		// show video description if field isn't empty
		if( $instance['video_description'] )
			echo '<div class="wpex-video-widget-description">'. $instance['video_description']. '</div>';
		echo $after_widget;
	}
	
}
// register Flickr widget
add_action('widgets_init', create_function('', 'return register_widget("wpex_video");'));