<?php
/**
 * Adds classes to the body tag for various page/post layout styles
 *
 * @package Total
 * @author Alexander Clarke
 * @copyright Copyright (c) 2014, Symple Workz LLC
 * @link http://www.wpexplorer.com
 * @since Total 1.0
*/

if ( !function_exists('wpex_body_classes') ) {

	function wpex_body_classes( $classes ) {
		
		// WPExplorer class
		$classes[] = 'wpex-theme';

		// Responsive
		$responsive = wpex_option('responsive','1');
		if ( $responsive == '1' ) {
			$classes[] = 'wpex-responsive';
		}
		
		// Add skin to body classes
		if ( function_exists( 'wpex_active_skin') ) {
			$site_theme = wpex_active_skin();
			if ( $site_theme ) {
				$classes[] = 'theme-'. $site_theme;
			}
		}
		
		// Page with Slider or header
		if ( is_singular() ) {
			global $post;
			$post_id = $post->ID;
			$slider = get_post_meta( $post_id, 'wpex_post_slider_shortcode', true );
			$title_style = get_post_meta( $post_id, 'wpex_post_title_style', true );
			if ( $slider ) {
				$classes[] = 'page-with-slider';
			}
			if ( $title_style == 'background-image' ) {
				$classes[] = 'page-with-background-title';
			}
		}
		
		// Layout Style
		if ( is_singular() ) {
			global $post;
			$meta = get_post_meta($post->ID, 'wpex_main_layout', true);
			if ( $meta == 'boxed' ) {
				$classes[] = $meta .'-main-layout';
			} else {
				$classes[] = wpex_option( 'main_layout_style', 'full-width') .'-main-layout';
			}
		} else {
			$classes[] = wpex_option( 'main_layout_style', 'full-width') .'-main-layout';
		}
		
		// Remove header bottom margin
		if ( is_singular() ) {
			global $post;
			$disable_header_margin = get_post_meta($post->ID, 'wpex_disable_header_margin', true);
			$slider = get_post_meta( $post->ID, 'wpex_post_slider_shortcode', true );
			if ( $disable_header_margin == 'on' || $slider ) {
				$classes[] = 'no-header-margin';
			}

		}
		
		// WooCommerce
		if ( class_exists('Woocommerce') ) {
			if ( wpex_option( 'woo_shop_slider' ) !== '' && is_shop() ) {
				$classes[] = 'page-with-slider';
			}
			if ( wpex_option( 'woo_shop_title', '1' ) !== '1' && is_shop() ) {
				$classes[] = 'page-without-title';
			}
		}

		// Widget Icons
		if ( wpex_option('widget_icons', '1' ) == '1' ) {
			$classes[] = 'sidebar-widget-icons';
		}

		// Mobile
		if ( wp_is_mobile() ) {
			$classes[] = 'is-mobile';
		}
		
		return $classes;
	}
}

add_filter( 'body_class', 'wpex_body_classes' );