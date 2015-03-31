<?php
/**
 * Recent Recent Comments With Avatars Widget
 *
 * @package	Total
 * @author Alexander Clarke
 * @copyright Copyright (c) 2014, Symple Workz LLC
 * @link http://www.wpexplorer.com
 * @since Total 1.0
*/

class wpex_recent_comments_avatars_widget extends WP_Widget {
	
	/** constructor */
	function wpex_recent_comments_avatars_widget() {
		parent::WP_Widget(false, $name = WPEX_THEME_BRANDING . ' - '. __('Recent Comments With Avatars','wpex'), array( 'description' => __( 'Displays your recent comments with avatars.', 'wpex' ) ) );
	}

	/** @see WP_Widget::widget */
	function widget($args, $instance) {
		extract( $args );
		$title = $instance['title'];
		$number = $instance['number'];
		echo $before_widget;
		if ( $title ) {
			echo $before_title . $title . $after_title;
		} ?>
		<ul class="wpex-recent-comments-widget clr">
			<?php
			// Query Posts
			$comments = get_comments( array (
				'number'		=> $number,
				'status'		=> 'approve',
				'post_status'	=> 'publish',
				'type'			=> 'comment'
			) );
			if ( $comments ) {
				foreach ( $comments as $comment ) { ?>
					<li class="clr">
						<a href="<?php echo get_permalink( $comment->comment_post_ID ) . '#comment-' . $comment->comment_ID; ?>" title="<?php the_title(); ?>" class="avatar"><?php echo get_avatar( $comment->comment_author_email, '50' ); ?></a>
						<strong><?php echo get_comment_author( $comment->comment_ID ); ?>:</strong> <?php echo wp_trim_words( $comment->comment_content, '10' ); ?>...
						<br/ >
						<a href="<?php echo get_permalink( $comment->comment_post_ID ) . '#comment-' . $comment->comment_ID; ?>" title="<?php the_title(); ?>"><?php _e( 'view comment', 'wpex' ); ?> &rarr;</a>
						</a>
					</li>
				<?php }
			} else { ?>
				<li style="padding-left:0;"><?php _e( 'No comments yet.', 'wpex' ); ?></li>
			<?php } ?>
		</ul>
	<?php echo $after_widget;
	}

	/** @see WP_Widget::update */
	function update($new_instance, $old_instance) {
	$instance = $old_instance;
	$instance['title'] = strip_tags($new_instance['title']);
	$instance['number'] = strip_tags($new_instance['number']);
		return $instance;
	}

	/** @see WP_Widget::form */
	function form($instance) {
		$instance = wp_parse_args( (array) $instance, array(
			'title'		=> __( 'Recent Comments', 'wpex' ),
			'number'	=> '3',

		));
		$title = esc_attr($instance['title']);
		$number = esc_attr($instance['number']); ?>
		
		
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'wpex'); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title','wpex'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number to Show:', 'wpex'); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" />
		</p>

		<?php
	}


} // class wpex_recent_comments_avatars_widget
// register Recent Posts widget
add_action('widgets_init', create_function('', 'return register_widget("wpex_recent_comments_avatars_widget");')); ?>