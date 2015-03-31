<?php
class wpex_simple_menu extends WP_Widget {

	/*constructor*/
	function wpex_simple_menu() {
		parent::WP_Widget(false, $name = WPEX_THEME_BRANDING . ' - '. __( 'Simple Custom Menu', 'wpex' ), array( 'description' => __( 'Displays a custom menu without any toggles or styling.', 'wpex' ) ) );
	}

	/**/
	function widget($args, $instance) {
		extract( $args );

		// widget options
		$title = apply_filters( 'widget_title', $instance['title'] );
		$nav_menu1 = ! empty( $instance['nav_menu'] ) ? wp_get_nav_menu_object( $instance['nav_menu'] ) : false;
		echo $before_widget;
		if ($title) {
			echo $before_title . $title . $after_title;
		}

		if ($nav_menu1) {
			echo wp_nav_menu( array(
				'fallback_cb'	=> '',
				'menu'			=> $nav_menu1
				)
			);
		}

		echo $after_widget;
	}

	/* saves options chosen from the widgets panel */
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['nav_menu'] = (int) $new_instance['nav_menu'];
		return $instance;
	}

	/* display widget in widgets panel */
	function form($instance) {
		$instance = wp_parse_args( (array) $instance, array(
			'title'		=> __( 'Simple Custom Menu', 'wpex' ),
		));
		$title = esc_attr($instance['title']);
		$nav_menu1 = isset( $instance['nav_menu'] ) ? $instance['nav_menu'] : '';
		$menus1 = get_terms( 'nav_menu', array( 'hide_empty' => false ) ); ?>

		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'wpex'); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title','wpex'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('nav_menu'); ?>"><?php _e('Select Menu:','wpex'); ?></label>
			<select id="<?php echo $this->get_field_id('nav_menu'); ?>" name="<?php echo $this->get_field_name('nav_menu'); ?>">
				<?php
					foreach ( $menus1 as $menu1 ) {
						echo '<option value="' . $menu1->term_id . '"'
							. selected( $nav_menu, $menu1->term_id, false )
							. '>'. $menu1->name . '</option>';
					}
				?>
			</select>
		</p>

		<?php
	}

} // End class

// Register widget
add_action('widgets_init', create_function('', 'return register_widget("wpex_simple_menu");'));