<?php
// Create a recent posts thumb grid widget
class wpex_recent_posts_thumb_grid extends WP_Widget {
	
	/** constructor */
	function wpex_recent_posts_thumb_grid() {
		parent::WP_Widget(false, $name = WPEX_THEME_BRANDING . ' - '. __( 'Recent Posts Thumbnail Grid', 'wpex' ), array( 'description' => __( 'Displays a grid of featured images for your post type of choice.', 'wpex' ) ) );
	}

	/** @see WP_Widget::widget */
	function widget($args, $instance) {

		extract( $args );

		$title = $instance['title'];
		$post_type = $instance['post_type']; 
		$number = $instance['number'];
		$order = $instance['order'];  
			echo $before_widget;
				if ( $title )
				echo $before_title . $title . $after_title; ?>
					<ul class="wpex-recent-posts-thumb-grid clearfix">
						<?php
						global $post;
						$args = array(
							'post_type'			=> $post_type,
							'numberposts'		=> $number,
							'orderby'			=> $order,
							'no_found_rows'		=> true,
							'meta_key'			=> '_thumbnail_id',
							'suppress_filters'	=> false,
						);
						$myposts = get_posts( $args );
						$count=0;
						foreach( $myposts as $post ) : setup_postdata($post);
							$count++;
							if( has_post_thumbnail() ) { ?>
								<li><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><img src="<?php echo wpex_image_resize( wp_get_attachment_url( get_post_thumbnail_id() ), '65', '65',  true ); ?>" alt="<?php the_title(); ?>" /></a></li>
						<?php
						}
						if ( $count == 3 ) { $count = '0'; }
						endforeach;
						wp_reset_postdata(); ?>
					</ul>
			<?php echo $after_widget;
	}

	/** @see WP_Widget::update */
	function update($new_instance, $old_instance) {
	$instance = $old_instance;
	$instance['title'] = strip_tags($new_instance['title']);
	$instance['post_type'] = strip_tags($new_instance['post_type']);
	$instance['number'] = strip_tags($new_instance['number']);
	$instance['order'] = strip_tags($new_instance['order']);
		return $instance;
	}

	/** @see WP_Widget::form */
	function form($instance) {

		$instance = wp_parse_args( (array) $instance, array(
			'title'			=> __('Recent Posts','wpex'),
			'post_type'		=> 'post',
			'number'		=> '6',
			'order'			=> 'ASC',
		) );
		$title		= esc_attr( $instance['title']);
		$number		= esc_attr( $instance['number']);
		$post_type	= esc_attr( $instance['post_type'] );
		$order		= esc_attr( $instance['order'] );?>
		
		
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'wpex'); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title','wpex'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
		
		<p>
		<label for="<?php echo $this->get_field_id('post_type'); ?>"><?php _e('Post Type?', 'wpex'); ?></label> 
		<br />
		<select class='wpex-select' name="<?php echo $this->get_field_name('post_type'); ?>" id="<?php echo $this->get_field_id('post_type'); ?>">
			<option value="post" <?php if($post_type == 'post') { ?>selected="selected"<?php } ?>><?php _e('Post', 'wpex'); ?></option>
			<?php
			//get post types
			$args = array('public' => true,'_builtin' => false, 'exclude_from_search' => false); 
			$output = 'names'; // or objects
			$operator = 'and'; // 'and' or 'or'
			$get_post_types = get_post_types($args,$output,$operator); 
			foreach ($get_post_types as $get_post_type ) {
				if( $get_post_type !== 'faq' ){ ?>
				<option value="<?php echo $get_post_type; ?>" id="<?php $get_post_type; ?>" <?php if($post_type == $get_post_type) { ?>selected="selected"<?php } ?>><?php echo $get_post_type; ?></option>
			<?php } } ?>
		</select>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('order'); ?>"><?php _e('Random or Recent?', 'wpex'); ?></label>
			<br />
			<select class='wpex-select' name="<?php echo $this->get_field_name('order'); ?>" id="<?php echo $this->get_field_id('order'); ?>">
			<option value="ASC" <?php if($order == 'ASC') { ?>selected="selected"<?php } ?>><?php _e('Recent', 'wpex'); ?></option>
			<option value="rand" <?php if($order == 'rand') { ?>selected="selected"<?php } ?>><?php _e('Random', 'wpex'); ?></option>
			</select>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number to Show:', 'wpex'); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" />
		</p>
		
		<?php
	}


} // class wpex_recent_posts_thumb_grid
// register Recent Posts widget
add_action('widgets_init', create_function('', 'return register_widget("wpex_recent_posts_thumb_grid");')); ?>