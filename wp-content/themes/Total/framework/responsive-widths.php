<?php
/**
 * This file is used for all the styling options in the admin
 * All custom color options are output to the <head> tag
 *
 * @package Total
 * @author Alexander Clarke
 * @copyright Copyright (c) 2014, Symple Workz LLC
 * @link http://www.wpexplorer.com
 * @since Total 1.0
 */

// Not needed in the admin
if ( is_admin() ) {
	return;
}

if ( !function_exists( 'wpex_responsive_widths' ) ) {
	function wpex_responsive_widths() {
		
		//if ( wpex_option('custom_mobile_widths','1') !== '1' ) return;
	
		$custom_css ='';

		/**
			Tablet Portrait
		**/
		
		// Tablet Widths
		$tablet_landscape_main_container_width = wpex_option( 'tablet_landscape_main_container_width' );
		$tablet_landscape_main_container_width = ( '980px' != $tablet_landscape_main_container_width ) ? $tablet_landscape_main_container_width : '';
		
		$tablet_landscape_left_container_width = wpex_option( 'tablet_landscape_left_container_width' );
		$tablet_landscape_left_container_width = ( '680px' != $tablet_landscape_left_container_width ) ? $tablet_landscape_left_container_width : '';
		
		$tablet_landscape_sidebar_width = wpex_option( 'tablet_landscape_sidebar_width' );
		$tablet_landscape_sidebar_width = ( '250px' != $tablet_landscape_sidebar_width ) ? $tablet_landscape_sidebar_width : '';
		
		if ( $tablet_landscape_main_container_width || $tablet_landscape_left_container_width || $tablet_landscape_sidebar_width ) {
			
			$custom_css .= '@media only screen and (min-width: 960px) and (max-width: 1280px) {';
				
				if ( $tablet_landscape_main_container_width ) {
					$custom_css .= '.container { width: '. $tablet_landscape_main_container_width .'; }';
				}
				
				if ( $tablet_landscape_left_container_width ) {
					$custom_css .= '.content-area { width: '. $tablet_landscape_left_container_width .' !important; }';
				}
				
				if ( $tablet_landscape_sidebar_width ) {
					$custom_css .= '#sidebar { width: '. $tablet_landscape_sidebar_width .' !important; }';
				}
			
			$custom_css .= '}';
		
		}

		/**
			Tablet Portrait
		**/
		
		// Tablet Widths
		$tablet_main_container_width = wpex_option( 'tablet_main_container_width' );
		$tablet_main_container_width = ( '700px' != $tablet_main_container_width ) ? $tablet_main_container_width : '';
		
		$tablet_left_container_width = wpex_option( 'tablet_left_container_width' );
		$tablet_left_container_width = ( '440px' != $tablet_left_container_width ) ? $tablet_left_container_width : '';
		
		$tablet_sidebar_width = wpex_option( 'tablet_sidebar_width' );
		$tablet_sidebar_width = ( '220px' != $tablet_sidebar_width ) ? $tablet_sidebar_width : '';
		
		if ( $tablet_main_container_width || $tablet_left_container_width || $tablet_sidebar_width ) {
			
			$custom_css .= '@media only screen and (min-width: 768px) and (max-width: 959px) {';
				
				if ( $tablet_main_container_width ) {
					$custom_css .= '.container, .wpb_row .wpb_row, .vc_row-fluid.container { width: '. $tablet_main_container_width .'; }';
				}
				
				if ( $tablet_left_container_width ) {
					$custom_css .= '.content-area { width: '. $tablet_left_container_width .' !important; }';
				}
				
				if ( $tablet_sidebar_width ) {
					$custom_css .= '#sidebar { width: '. $tablet_sidebar_width .' !important; }';
				}
			
			$custom_css .= '}';
		
		}

		/**
			Phone Size
		**/
		
		// Phone Portrait
		$mobile_portrait_main_container_width = wpex_option( 'mobile_portrait_main_container_width' );
		if ( $mobile_portrait_main_container_width && '90%' != $mobile_portrait_main_container_width  ) {
			$custom_css .= '@media only screen and (max-width: 767px) {
				.container { width: '. $mobile_portrait_main_container_width .' !important; min-width: 0; }
			}';
		}
		
		// Phone Landscape
		$mobile_landscape_main_container_width = wpex_option( 'mobile_landscape_main_container_width' );
		if ( $mobile_landscape_main_container_width && '480px' != $mobile_landscape_main_container_width ) {
			$custom_css .= '@media only screen and (min-width: 480px) and (max-width: 767px) {
				.container { width: '. $mobile_landscape_main_container_width .' !important; }
			}';
		}

		/**
			Output
		**/
	
		// trim white space for faster page loading
		$custom_css_trimmed =  preg_replace( '/\s+/', ' ', $custom_css );
		
		// output css on front end
		$css_output = "<!-- Responsive Widths CSS -->\n<style type=\"text/css\">\n" . $custom_css_trimmed . "\n</style>";
		if( !empty( $custom_css ) ) {
			echo $css_output;
		}
		
	}
}

add_action('wp_head', 'wpex_responsive_widths');