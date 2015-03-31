<?php
/**
 * Function used to display custom backgrounds on a per-page basis
 *
 * @package WordPress
 * @subpackage Total
 * @since Total 1.1
*/

if ( ! function_exists('wpex_page_backgrounds') ) {
	
	function wpex_page_backgrounds( $title='' ) {
		
		// Only run on pages
		if ( !is_singular() ) return;
		
		global $post;
		$post_id = $post->ID;
		$css = '';
		$background_color = get_post_meta( $post_id, 'wpex_page_background_color', true );
		$background_image = get_post_meta( $post_id, 'wpex_page_background_image', true );
		$background_image_style = get_post_meta( $post_id, 'wpex_page_background_image_style', true );
		
		// Background color
		if ( $background_color && $background_color !== '#' ) {
			$css .= 'body { background-color: '. $background_color .' !important; }';
		}
		
		// Background Image
		if ( $background_image ) {
			if ( 'repeat' == $background_image_style  || '' == $background_image_style ) {
				$css .= 'body { background: url('. $background_image .') repeat !important; }';
			}
			if ( 'fixed' == $background_image_style ) {
				$css .= 'body { background: url('. $background_image .') center top fixed no-repeat !important; }';
			}
			if ( 'stretched' == $background_image_style || 'streched' == $background_image_style  ) {
				$css .= 'body { background: url('. $background_image .') no-repeat center center fixed !important; -webkit-background-size: cover;-moz-background-size: cover;-o-background-size: cover;background-size: cover; }';
			}
		}
		
		// trim white space for faster page loading
		$css = preg_replace( '/\s+/', ' ', $css );
		
		if ( '' != $css ) {
			$css = '/*Admin Page Background CSS START*/'. $css .'/*Admin Page Background CSS END*/';
			return $css;
		} else {
			return '';
		}
		

	} // End functions
	
} // End if function exists