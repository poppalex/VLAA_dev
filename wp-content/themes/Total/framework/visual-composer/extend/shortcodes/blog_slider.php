<?php
/**
	THIS IS WORK IN PROGRESS
	Register Shortcode
**/
if( !function_exists( 'vcex_blog_flexslider_shortcode' ) ) {

	function vcex_blog_flexslider_shortcode($atts) {
		
		// Define shortcode params
		extract( shortcode_atts( array(
				'unique_id'				=> '',
				'term_slug'				=> 'all',
				'posts_per_page'		=> '4',
				'order'					=> 'DESC',
				'orderby'				=> 'date',
				'animation'				=> 'slide',
				'slideshow'				=> 'true',
				'randomize'				=> 'false',
				'direction'				=> 'horizontal',
				'slideshow_speed'		=> '7000',
				'animation_speed'		=> '600',
				'control_nav'			=> 'true',
				'direction_nav'			=> 'true',
				'pause_on_hover'		=> 'true',
				'smooth_height'			=> 'true',
				'img_width'				=> '9999',
				'img_height'			=> '9999',
			), $atts ) );
			
		$output = '';
		
		// Give flexslider a unique name
		$rand_num = rand(1, 100);
		$unique_flexslider_id = 'flexslider-'. $rand_num;
		
		// Output filter JS into the footer like a WP Jedi Master
		$output .='
			<script type="text/javascript">
				jQuery(function($){
					$(window).load(function() {
						$("#'. $unique_flexslider_id .'").flexslider({
							animation: "'. $animation .'",
							slideshow : '. $slideshow .',
							randomize : '. $randomize .',
							direction: "'. $direction .'",
							slideshowSpeed: '. $slideshow_speed .',
							animationSpeed: '. $animation_speed .',
							controlNav : '. $control_nav .',
							directionNav: '. $direction_nav .',
							pauseOnHover: '. $pause_on_hover .',
							smoothHeight: '. $smooth_height .',
							prevText : \'<i class=fa fa-chevron-left"></i>\',
							nextText : \'<i class="fa fa-chevron-right"></i>\'
						});
					});
				});
			</script>';

		//Output images
		if( $attachments ) :
		
			$unique_id = $unique_id ? ' id="'. $unique_id .'"' : NULL;
		
			// Main wrapper div
			$output .= '<div class="vcex-flexslider-wrap clr vcex-img-flexslider"'. $unique_id  .'>';

				$output .= '<div id="'. $unique_flexslider_id .'" class="vcex-flexslider flexslider"><ul class="slides">';
			
				// Loop through attachments
				$count=-1;
				foreach ( $attachments as $attachment ) :
				$count++;
					
					// Crop featured images if necessary
					$thumbnail_hard_crop = $img_height == '9999' ? false : true;
					$img_width = intval($img_width);
					$img_height = intval($img_height);
					$attachment_img = wpex_image_resize( $attachment_img, $img_width, $img_height, $thumbnail_hard_crop );
					
					// Image output
					$image_output = '<img src="'. $attachment_img .'" alt="'. $attachment_alt .'" />';
		
					// Slide item start
					$output .= '<li class="vcex-flexslider-slide slide">';
					
							$output .= '<div class="vcex-flexslider-entry-media">';
							
								if ( $thumbnail_link == 'lightbox' ) {
									$output .= '<a href="'. $attachment_img_url .'" title="'. $attachment_alt .'" class="vcex-flexslider-entry-img vcex-lightbox">';
										$output .= $image_output;
									$output .= '</a>';
								} elseif ( $thumbnail_link == 'custom_link' ) {
									$custom_link = !empty($custom_links[$count]) ? $custom_links[$count] : '#';
									if ( $custom_link == '#' ) {
										$output .= $image_output;
									} else {
										$output .= '<a href="'. $custom_link .'" title="'. $attachment_alt .'" class="vcex-flexslider-entry-img" target="'. $custom_links_target .'">';
											$output .= $image_output;
										$output .= '</a>';
									}
								} else {
									$output .= $image_output;
								}
								
								if ( $caption == 'true' && $attachment_caption ) {
									$output .= '<div class="vcex-flexslider-entry-title">'. $attachment_caption .'</div>';
								}
								
							$output .= '</div>';
						
					// Close main wrap
					$output .= '</li>';
				
				// End foreach loop
				endforeach;
				
				// End UL
				$output .= '</ul>';
			
			// Close main wrap
			$output .= '</div></div><div class="vcex-clear-floats"></div>';
		
		endif; // End has posts check
		
		// Reset query
		wp_reset_postdata();

		// Return data
		return $output; 
		
	}
	add_shortcode( 'vcex_blog_flexslider', 'vcex_blog_flexslider_shortcode' );
}



/**
	Add to visual composer
**/
add_action( 'init', 'vcex_blog_flexslider_vc_map' );
if ( ! function_exists( 'vcex_blog_flexslider_vc_map' ) ) {
	function vcex_blog_flexslider_vc_map() {
		vc_map( array(
			"name"					=> __( "Blog Slider", 'wpex' ),
			"description"			=> __( "Recent posts slider.", 'wpex' ),
			"base"					=> "vcex_blog_flexslider",
			"class"					=> "",
			'category'				=> WPEX_THEME_BRANDING,
			'admin_enqueue_js'		=> "",
			'admin_enqueue_css'		=> "",
			"icon" 					=> "icon-wpb-vcex-blog_flexslider",
			"params"				=> array(
				array(
					"type"			=> "textfield",
					"class"			=> "",
					"heading"		=> __( "Unique Id", 'wpex' ),
					"param_name"	=> "unique_id",
					"value"			=> "",
					"description"	=> __( "You can enter a unique ID here for styling purposes.", 'wpex' ),
				),
				array(
					"type"			=> "textfield",
					"class"			=> "",
					"heading"		=> __( "Category", 'wpex' ),
					"param_name"	=> "term_slug",
					"admin_label"	=> true,
					"value"			=> "all",
					"description"	=> __('Enter the slug of a category to pull posts from or enter all to pull recent posts from all categories.','wpex'),
					'group'			=> __( 'Query', 'wpex' ),
				),
				array(
					"type"			=> "dropdown",
					"class"			=> "",
					"heading"		=> __( "Order", 'wpex' ),
					"param_name"	=> "order",
					"description"	=> sprintf( __( 'Designates the ascending or descending order. More at %s.', 'wpex' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex</a>' ),
					"value"			=> array(
						 __( "DESC", "wpex")	=> "DESC",
						 __( "ASC", "wpex" )	=> "ASC",
					),
					'group'			=> __( 'Query', 'wpex' ),
				),
				array(
					"type"			=> "dropdown",
					"class"			=> "",
					"heading"		=> __( "Order By", 'wpex' ),
					"param_name"	=> "orderby",
					"description"	=> sprintf( __( 'Select how to sort retrieved posts. More at %s.', 'wpex' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex</a>' ),
					"value"			=> array(
						__( "Date", "wpex")				=> "date",
						__( "Name", "wpex" )				=> "name",
						__( "Modified", "wpex")			=> "modified",
						__( "Author", "wpex" )			=> "author",
						__( "Random", "wpex")				=> "rand",
						__( "Comment Count", "wpex" )	=> "comment_count",
					),
					'group'			=> __( 'Query', 'wpex' ),
				),
				array(
					"type"			=> "textfield",
					"class"			=> "",
					"heading"		=> __( "Posts Count", 'wpex' ),
					"param_name"	=> "posts_per_page",
					"value"			=> "4",
					"description"	=> __( "How many items do you wish to show?", 'wpex' ),
					'group'			=> __( 'Query', 'wpex' ),
				),
				array(
					"type"			=> "dropdown",
					"class"			=> "",
					"heading"		=> __( "Animation", 'wpex' ),
					"param_name"	=> "animation",
					"value"			=> array(
						__( "Slide", "wpex")	=> "slide",
						__( "Fade", "wpex" )	=> "fade",
					),
					"description"	=> __( "Select your animation style.", 'wpex' ),
				),
				array(
					"type"			=> "dropdown",
					"class"			=> "",
					"heading"		=> __( "Slideshow", 'wpex' ),
					"param_name"	=> "slideshow",
					"value"			=> array(
						__( "True", "wpex")		=> "true",
						__( "False", "wpex" )	=> "false",
					),
					"description"	=> __( "Enable automatic slideshow?", 'wpex' ),
				),
				array(
					"type"			=> "dropdown",
					"class"			=> "",
					"heading"		=> __( "Randomize", 'wpex' ),
					"param_name"	=> "randomize",
					"value"			=> array(
						__( "False", "wpex" )	=> "false",
						__( "True", "wpex")		=> "true",
					),
					"description"	=> __( "Randomize image order display on page load?", 'wpex' ),
				),
				array(
					"type"			=> "dropdown",
					"class"			=> "",
					"heading"		=> __( "Control Nav", 'wpex' ),
					"param_name"	=> "control_nav",
					"value"			=> array(
						__( "True", "wpex")		=> "true",
						__( "False", "wpex" )	=> "false",
					),
					"description"	=> __( 'Display the control navigation? These are the white "dots" at the top of the slider.', 'wpex' ),
				),
				array(
					"type"			=> "dropdown",
					"class"			=> "",
					"heading"		=> __( "Direction Nav", 'wpex' ),
					"param_name"	=> "direction_nav",
					"value"			=> array(
						__( "True", "wpex")		=> "true",
						__( "False", "wpex" )	=> "false",
					),
					"description"	=> __( "Display the next and previous arrows?", 'wpex' ),
				),
				array(
					"type"			=> "textfield",
					"class"			=> "",
					"heading"		=> __( "Slideshow Speed", 'wpex' ),
					"param_name"	=> "slideshow_speed",
					"value"			=> "7000",
					"description"	=> __( "Enter your desired slideshow speed in milliseconds. Default is 7000.", 'wpex' ),
				),
				array(
					"type"			=> "textfield",
					"class"			=> "",
					"heading"		=> __( "Animation Speed", 'wpex' ),
					"param_name"	=> "animation_speed",
					"value"			=> "600",
					"description"	=> __( "Enter your desired animation speed in milliseconds. Default is 600.", 'wpex' ),
				),
				array(
					"type"			=> "textfield",
					"class"			=> "",
					"heading"		=> __( "Image Width", 'wpex' ),
					"param_name"	=> "img_width",
					"value"			=> "9999",
					"description"	=> __( "Custom image cropping width. Enter 9999 for no cropping.", 'wpex' ),
					'group'			=> __( 'Image Settings', 'wpex' ),
				),
				array(
					"type"			=> "textfield",
					"class"			=> "",
					"heading"		=> __( "Image Height", 'wpex' ),
					"param_name"	=> "img_height",
					"value"			=> "9999",
					"description"	=> __( "Custom image cropping height. Enter 9999 for no cropping.", 'wpex' ),
					'group'			=> __( 'Image Settings', 'wpex' ),
				),
			)
			
		) );
	}
}