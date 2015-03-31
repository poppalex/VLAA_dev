<?php
// Excerpts
if ( !function_exists( 'vcex_excerpt' ) ) {
	function vcex_excerpt( $length=30, $readmore=false, $read_more_text='', $post_id='' ) {
		global $post;
		$id = $post_id ? $post_id : $post->ID;
		$custom_excerpt = $post->post_excerpt;
		$post_content = get_the_content( $id );
		$output = '';
		// Return Excerpt
		if ( '0' != $length ) {
			// Custom Excerpt
			if ( $custom_excerpt ) {
				if ( '-1' ==  $length ) {
					$output = apply_filters( 'the_content', $custom_excerpt );
				} else {
					$custom_excerpt = wp_trim_words( $custom_excerpt, $length );
					$output = apply_filters( 'the_content', $custom_excerpt );
				}
			} else {
				// Return the content
				if ( '-1' ==  $length ) {
					return apply_filters( 'the_content', $post_content );
				}
				// Excerpt length
				$meta_excerpt = get_post_meta( $id, 'vcex_excerpt_length', true );
				$length = $meta_excerpt ? $meta_excerpt : $length;
				// Readmore text
				$read_more_text = $read_more_text ? $read_more_text : __('view post', 'wpex' );
				// Check if text shortcode in post
				if ( strpos( $post_content, '[vc_column_text]') ) {
					$pattern = '{\[vc_column_text\](.*?)\[/vc_column_text\]}is';
					preg_match( $pattern, $post_content, $match );
					if( isset( $match[1] ) ) {
						//$excerpt = str_replace('[vc_column_text]', '', $match[0] );
						//$excerpt = str_replace('[/vc_column_text]', '', $excerpt );
						$excerpt = wp_trim_words( $match[1], $length );
					} else {
						$content = strip_shortcodes( $post_content );
						$excerpt = wp_trim_words( $content, $length );
					}
				} else {
					$content = strip_shortcodes( $post_content );
					$excerpt = wp_trim_words( $content, $length );
				}
				// Output Excerpt
				$excerpt = wp_kses( $excerpt, array( 'a' => array( 'href' => array(), 'title' => array() ), 'br' => array(), 'em' => array(), 'strong' => array() ) );
				$output .= '<p>'. html_entity_decode($excerpt) .'</p>';
			}

			// Readmore link
			if ( $readmore == true ) {
				$readmore_link = '<a href="'. get_permalink( $id ) .'" title="'.$read_more_text .'" rel="bookmark" class="vcex-readmore theme-button">'. $read_more_text .' <span class="vcex-readmore-rarr">&rarr;</span></a>';
				$output .= apply_filters( 'vcex_readmore_link', $readmore_link );
			}
			
			// Output
			echo $output;
		}
	}
}

// Get Excerpt
if ( !function_exists( 'vcex_get_excerpt' ) ) {
	function vcex_get_excerpt( $length=30, $readmore=false, $read_more_text='', $post_id='' ) {
		global $post;
		$id = $post_id ? $post_id : $post->ID;
		$custom_excerpt = $post->post_excerpt;
		$post_content = get_the_content( $id );
		$output = '';
		if ( '-1' ==  $length ) {
			return apply_filters( 'the_content', $post_content );
		}
		if ( '0' != $length ) {
			// Custom Excerpt
			if ( $custom_excerpt ) {
				if ( '-1' ==  $length ) {
					$output = apply_filters( 'the_content', $custom_excerpt );
				} else {
					$custom_excerpt = wp_trim_words( $custom_excerpt, $length );
					$output = apply_filters( 'the_content', $custom_excerpt );
				}
			} else {
				// Excerpt length
				$meta_excerpt = get_post_meta( $id, 'vcex_excerpt_length', true );
				$length = $meta_excerpt ? $meta_excerpt : $length;
				// Readmore text
				$read_more_text = $read_more_text ? $read_more_text : __('view post', 'wpex' );
				// Check if text shortcode in post
				if ( strpos( $post_content, '[vc_column_text]') ) {
					$pattern = '{\[vc_column_text\](.*?)\[/vc_column_text\]}is';
					preg_match( $pattern, $post_content, $match );
					if( isset( $match[1] ) ) {
						//$excerpt = str_replace('[vc_column_text]', '', $match[0] );
						//$excerpt = str_replace('[/vc_column_text]', '', $excerpt );
						$excerpt = wp_trim_words( $match[1], $length );
					} else {
						$content = strip_shortcodes( $post_content );
						$excerpt = wp_trim_words( $content, $length );
					}
				} else {
					$content = strip_shortcodes( $post_content );
					$excerpt = wp_trim_words( $content, $length );
				}
				// Output Excerpt
				$excerpt = wp_kses( $excerpt, array( 'a' => array( 'href' => array(), 'title' => array() ), 'br' => array(), 'em' => array(), 'strong' => array() ) );
				$output .= '<p>'. html_entity_decode($excerpt) .'</p>';
			}
		}
		if ( $readmore == true ) {
			$readmore_link = '<a href="'. get_permalink( $id ) .'" title="'.$read_more_text .'" rel="bookmark" class="vcex-readmore theme-button">'. $read_more_text .' <span class="vcex-readmore-rarr">&rarr;</span></a>';
			$output .= apply_filters( 'vcex_readmore_link', $readmore_link );
		}
		
		return $output;
	}
}

// Image Filter Styles
if ( !function_exists( 'vcex_image_filters' ) ) {
	function vcex_image_filters() {
		$filters = array (
			__('None','wpex')		=> 'none',
			__('Grayscale','wpex')	=> 'grayscale',
		);
		return apply_filters( 'vcex_image_filters', $filters );
	}
}


// Image Hover Styles
if ( !function_exists( 'vcex_image_hovers' ) ) {
	function vcex_image_hovers() {
		$hovers = array (
			__('None','wpex')			=> '',
			__('Grow','wpex')			=> 'grow',
			__('Shrink','wpex')			=> 'shrink',
			__('Side Pan','wpex')		=> 'side-pan',
			__('Vertical Pan','wpex')	=> 'vertical-pan',
			__('Tilt','wpex')			=> 'tilt',
			__('Normal - Blurr','wpex')	=> 'blurr',
			__('Blurr - Normal','wpex')	=> 'blurr-invert',
			__('Sepia','wpex')			=> 'sepia',
			__('Fade Out','wpex')		=> 'fade-out',
			__('Fade In','wpex')		=> 'fade-in',
		);
		return apply_filters( 'vcex_image_hovers', $hovers );
	}
}

// Image Hover Styles
if ( !function_exists( 'vcex_image_rendering' ) ) {
	function vcex_image_rendering() {
		$render = array (
			__('Auto','wpex')			=> '',
			__('Crisp Edges','wpex')	=> 'crisp-edges',
		);
		return apply_filters( 'vcex_image_rendering', $render );
	}
}

// Overlays
if ( !function_exists( 'vcex_overlays_array' ) ) {
	function vcex_overlays_array( $style = 'default' ) {
		if ( !function_exists( 'wpex_overlay_styles_array' ) ) {
			return;
		}
		$overlays = wpex_overlay_styles_array( $style );
		if ( ! is_array( $overlays ) ) {
			return;
		}
		$overlays = array_flip( $overlays );
		return array(
			"type"			=> "dropdown",
			"class"			=> "",
			"heading"		=> __( "Image Overlay Style", 'wpex' ),
			"param_name"	=> "overlay_style",
			"value"			=> $overlays,
			"description"	=> __("Select your preferred overlay style for your featured images.", "vcex"),
			'group'			=> __( 'Image Settings', 'wpex' ),
		);
	}
}