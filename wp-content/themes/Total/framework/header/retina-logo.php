<?php
/**
 * This file is used for your retina ready logo
 *
 * @package WordPress
 * @subpackage Total
 * @since Total 1.0
*/


add_action('wp_head', 'wpex_retina_logo');
if ( ! function_exists( 'wpex_retina_logo' ) ) {
	function wpex_retina_logo() {
		$logo_url = wpex_option( 'retina_logo', '', 'url' );
		
		$logo_width = wpex_option( 'retina_logo_width' );
		$logo_height = wpex_option( 'retina_logo_height' );
		
		$logo_width = preg_replace('#[^0-9]#','',strip_tags($logo_width));
		$logo_height = preg_replace('#[^0-9]#','',strip_tags($logo_height));
		
		if ( $logo_url !== '' && $logo_width !== '' && $logo_height !== '') {
			$output = '<!-- Retina Logo -->
			<script type="text/javascript">
				jQuery(function($){
					if (window.devicePixelRatio == 2) {
						$("#site-logo img").attr("src", "'. $logo_url .'");
						$("#site-logo img").attr("width", "'. $logo_width .'");
						$("#site-logo img").attr("height", "'. $logo_height .'");
					 }
				});
			</script>';	
			$output =  preg_replace( '/\s+/', ' ', $output );
			echo $output;
		}
	}
}