<?php
/**
 * Adds custom classes to the header container
 *
 * @package WordPress
 * @subpackage Total
 * @since Total 1.1
*/


// Return the correct header style
if ( ! function_exists( 'wpex_get_header_style' ) ) {
	function wpex_get_header_style( $style = 'one' ) {
		$style = wpex_option('header_style','one');
		if ( is_singular() ) {
			global $post;
			$post_id = $post->ID;
			$meta = get_post_meta( $post_id, 'wpex_header_style', true );
			if ( $meta ) {
				$style = $meta;
			}
		}
		return $style;
	}
}

// Outputs the main header menu
if ( ! function_exists( 'wpex_header_classes' ) ) { 
	function wpex_header_classes() {
		
		$header_style = wpex_get_header_style();
		if ( wpex_is_front_end_composer() ) {
			$fixed_header = false;
		} else {
			$fixed_header = wpex_option( 'fixed_header', '1' );
		}
		$page_header_style = '';
		if ( is_singular( 'page' ) ) {
			$page_header_style = get_post_meta( get_the_ID(), 'wpex_page_header_style', true );
		}

		$classes = 'clr';

		// Main header style
		$classes .= ' header-'. $header_style;

		// Fixed Header
		if ( $fixed_header == '1' && !wp_is_mobile() && $header_style == 'one' ) {
			$classes .= ' fixed-scroll';
		}

		// Page Header Style
		if ( $page_header_style && 'default' != $page_header_style ) {
			$classes .= ' fixed-header';
		}
		
		$classes = apply_filters( 'wpex_header_classes', $classes );
		echo $classes;

	}
}
