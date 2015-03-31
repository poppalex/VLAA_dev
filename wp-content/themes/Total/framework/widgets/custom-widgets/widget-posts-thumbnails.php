<?php
class wpex_recent_posts_thumb extends WP_Widget {
	
	/** constructor */
	function wpex_recent_posts_thumb() {
		parent::WP_Widget(false, $name = WPEX_THEME_BRANDING . ' - '. __('Recent Posts With Thumbnails','wpex' ), array( 'description' => __( 'Shows a listing of your recent or random posts with their thumbnail for any chosen post type.', 'wpex' ) ) );
	}

	/** @see WP_Widget::widget */
	function widget($args, $instance) {
		extract( $args );
		$title = $instance['title'];
		$number = $instance['number'];
		$style = isset($instance['style']) ? $instance['style'] : '';
		$order = $instance['order'];
		$img_height = ( !empty( $instance['img_height'] ) ) ? intval( $instance['img_height'] ) : '65';
		$img_width = ( !empty( $instance['img_width'] ) ) ? intval( $instance['img_width'] ) : '65';
		$date = isset( $instance['date'] ) ? $instance['date'] : '';
		$post_type = $instance['post_type'];
			echo $before_widget;
				if ( $title )
						echo $before_title . $title . $after_title; ?>
							<ul class="wpex-widget-recent-posts clr style-<?php echo $style; ?>">
							<?php
								global $post;
								$args = array(
									'post_type'			=> $post_type,
									'numberposts'		=> $number,
									'orderby'			=> $order,
									'no_found_rows'		=> true,
									'suppress_filters'	=> false,
									'meta_key'			=> '_thumbnail_id',
								);
								$myposts = get_posts( $args );
								foreach( $myposts as $post ) : setup_postdata($post);
								if( has_post_thumbnail() ) {
									if ( '9999' == $img_height ){
										$img_crop = false;
									} else {
										$img_crop = true;
									}
									$featured_image = wpex_image_resize( wp_get_attachment_url( get_post_thumbnail_id() ), $img_width, $img_height, $img_crop ); ?>
									<li class="clearfix wpex-widget-recent-posts-li">
										<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="wpex-widget-recent-posts-thumbnail">
											<img src="<?php echo $featured_image; ?>" alt="<?php the_title(); ?>" />
										</a>
										<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="wpex-widget-recent-posts-title"><?php the_title(); ?></a>
										<?php if ( $date !== '1' ) { ?>
											<div class="wpex-widget-recent-posts-date"><?php echo get_the_date(); ?></div>
										<?php } ?>
									</li>
							<?php
							} endforeach; wp_reset_postdata(); ?>
							</ul>
			<?php echo $after_widget;
	}

	/** @see WP_Widget::update */
	function update($new_instance, $old_instance) {
	$instance = $old_instance;
	$instance['title'] = strip_tags($new_instance['title']);
	$instance['number'] = strip_tags($new_instance['number']);
	$instance['style'] = strip_tags($new_instance['style']);
	$instance['order'] = strip_tags($new_instance['order']);
	$instance['img_height'] = strip_tags($new_instance['img_height']);
	$instance['img_width'] = strip_tags($new_instance['img_width']);
	$instance['date'] = strip_tags($new_instance['date']);
	$instance['post_type'] = strip_tags($new_instance['post_type']);
		return $instance;
	}

	/** @see WP_Widget::form */
	function form($instance) {
		$instance = wp_parse_args( (array) $instance, array(
			'title'			=> __('Recent Posts','wpex' ),
			'style'			=> 'default',
			'post_type'		=> 'post',
			'number'		=> '3',
			'order'			=> 'ASC',
			'date'			=> '',
			'img_height'	=> '65',
			'img_width'		=> '65',
		) );
		$title = esc_attr($instance['title']);
		$number = esc_attr($instance['number']);
		$style = esc_attr($instance['style']);
		$order = esc_attr( $instance['order'] );
		$date = esc_attr( $instance['date'] );
		$img_height = esc_attr( $instance['img_height'] );
		$img_width = esc_attr( $instance['img_width'] );
		$post_type = esc_attr( $instance['post_type'] ); ?>
		
		
		<p>
		<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Title:', 'wpex' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title','wpex' ); ?>" type="text" value="<?php echo $title; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('style'); ?>"><?php _e( 'Style', 'wpex' ); ?></label>
			<br />
			<select class='wpex-select' name="<?php echo $this->get_field_name('style'); ?>" id="<?php echo $this->get_field_id('style'); ?>">
				<option value="default" <?php if($style == 'default') { ?>selected="selected"<?php } ?>><?php _e( 'Small Image', 'wpex' ); ?></option>
				<option value="fullimg" <?php if($style == 'fullimg') { ?>selected="selected"<?php } ?>><?php _e( 'Full Image', 'wpex' ); ?></option>
			</select>
		</p>
		
		<p>
		<label for="<?php echo $this->get_field_id('post_type'); ?>"><?php _e( 'Post Type?', 'wpex' ); ?></label> 
		<br />
		<select class='wpex-select' name="<?php echo $this->get_field_name('post_type'); ?>" id="<?php echo $this->get_field_id('post_type'); ?>">
			<option value="post" <?php if($post_type == 'post') { ?>selected="selected"<?php } ?>><?php _e( 'Post', 'wpex' ); ?></option>
			<?php
			//get post_typeonomies
			$args=array('public' => true,'_builtin' => false, 'exclude_from_search' => false); 
			$output = 'names'; // or objects
			$operator = 'and'; // 'and' or 'or'
			$get_post_types = get_post_types($args,$output,$operator);
			foreach ($get_post_types as $get_post_type ) {
				if( $get_post_type != 'post' && $get_post_type !== 'faq' ){ ?>
				<option value="<?php echo $get_post_type; ?>" id="<?php $get_post_type; ?>" <?php if($post_type == $get_post_type) { ?>selected="selected"<?php } ?>><?php echo ucfirst( $get_post_type ); ?></option>
			<?php } } ?>
		</select>
		</p>
		
		<p>
		<label for="<?php echo $this->get_field_id('order'); ?>"><?php _e( 'Random or Recent?', 'wpex' ); ?></label>
		<br />
		<select class='wpex-select' name="<?php echo $this->get_field_name('order'); ?>" id="<?php echo $this->get_field_id('order'); ?>">
			<option value="ASC" <?php if($order == 'ASC') { ?>selected="selected"<?php } ?>><?php _e( 'Recent', 'wpex' ); ?></option>
			<option value="rand" <?php if($order == 'rand') { ?>selected="selected"<?php } ?>><?php _e( 'Random', 'wpex' ); ?></option>
			<option value="comment_count" <?php if( $order == 'comment_count' ) { ?>selected="selected"<?php } ?>><?php _e( 'Most Comments', 'wpex' ); ?></option>
			<option value="modified" <?php if( $order == 'modified' ) { ?>selected="selected"<?php } ?>><?php _e( 'Last Modified', 'wpex' ); ?></option>
		</select>
		</p>
		
		<p>
		<label for="<?php echo $this->get_field_id('number'); ?>"><?php _e( 'Number to Show', 'wpex' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" />
		</p>

		<p>
		<label for="<?php echo $this->get_field_id('img_width'); ?>"><?php _e( 'Image Crop Width', 'wpex' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id('img_width'); ?>" name="<?php echo $this->get_field_name('img_width'); ?>" type="text" value="<?php echo $img_width; ?>" />
		</p>

		<p>
		<label for="<?php echo $this->get_field_id('img_height'); ?>"><?php _e( 'Image Crop Height', 'wpex' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id('img_height'); ?>" name="<?php echo $this->get_field_name('img_height'); ?>" type="text" value="<?php echo $img_height; ?>" />
		</p>

		<p>
			<input id="<?php echo $this->get_field_id('date'); ?>" name="<?php echo $this->get_field_name('date'); ?>" type="checkbox" value="1" <?php checked( '1', $date ); ?> />
			<label for="<?php echo $this->get_field_id('date'); ?>"><?php _e( 'Disable Date?', 'wpex' ); ?></label>
		</p>

		
		<?php
	}


} // class wpex_recent_posts_thumb
// register Recent Posts widget
add_action('widgets_init', create_function('', 'return register_widget("wpex_recent_posts_thumb");')); ?>