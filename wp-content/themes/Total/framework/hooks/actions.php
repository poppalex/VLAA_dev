<?php
/**
 * Adds theme functions to hooks
 *
 * The following functions run certain functions in their corresponding hooks.
 * For example the header logo runs in the wpex_hook_header_inner hook.
 * You can copy and paste any of these functions into your child theme to change the
 * order of the displayed elements or remove any - have fun!
 *
 * @package WordPress
 * @subpackage Total
 * @since 1.1
*/


/**
	ADD ACTIONS & FILTERS
**/

// Theme actions
add_action( 'wpex_hook_header_before', 'wpex_hook_header_before_default' );
add_action( 'wpex_hook_header_inner', 'wpex_hook_header_inner_default' );
add_action( 'wpex_hook_header_bottom', 'wpex_hook_header_bottom_default' );
add_action( 'wpex_hook_main_top', 'wpex_hook_main_top_default' );
add_action( 'wpex_hook_sidebar_inner', 'wpex_hook_sidebar_inner_default' );
add_action( 'wpex_hook_footer_before', 'wpex_hook_footer_before_default' );
add_action( 'wpex_hook_footer_inner', 'wpex_hook_footer_inner_default' );
add_action( 'wpex_hook_footer_after', 'wpex_hook_footer_after_default' );
add_action( 'wpex_hook_wrap_after', 'wpex_hook_wrap_after_default' );

/**
	Header: Before
**/
if( ! function_exists( 'wpex_hook_header_before_default' ) ) {
	function wpex_hook_header_before_default() {
		wpex_toggle_bar_btn();
		wpex_top_bar();
	}
}

/**
	Header: Inner
**/
if( ! function_exists( 'wpex_hook_header_inner_default' ) ) {
	function wpex_hook_header_inner_default() {
		wpex_header_logo();
		wpex_header_aside();
		$header_style = wpex_get_header_style();
		if ( $header_style == 'one' ) {
			wpex_header_menu();
		}
		wpex_mobile_menu();
	}
}

/**
	Header: Bottom
**/
if( ! function_exists( 'wpex_hook_header_bottom_default' ) ) {
	function wpex_hook_header_bottom_default() {
		$header_style = wpex_get_header_style();
		if ( $header_style == 'two' || $header_style == 'three' ) {
			wpex_header_menu();
		}
	}
}

/**
	Main: Top
**/
if( ! function_exists( 'wpex_hook_main_top_default' ) ) {
	function wpex_hook_main_top_default() {
		wpex_display_page_header();
		wpex_post_slider();
	}
}

/**
	Sidebar: Inner
**/
if( ! function_exists( 'wpex_hook_sidebar_inner_default' ) ) {
	function wpex_hook_sidebar_inner_default() {
		// Display dynamic sidebar
		// See functions/widgets/get-sidebar.php
		dynamic_sidebar( wpex_get_sidebar() );
	}
}

/**
	Footer: Before
**/
if( ! function_exists( 'wpex_hook_footer_before_default' ) ) {
	function wpex_hook_footer_before_default() {
		wpex_footer_callout();
	}
}

/**
	Footer: Inner
**/
if( ! function_exists( 'wpex_hook_footer_inner_default' ) ) {
	function wpex_hook_footer_inner_default() {
		wpex_footer_widgets();
	}
}

/**
	Footer: After
**/
if( ! function_exists( 'wpex_hook_footer_after_default' ) ) {
	function wpex_hook_footer_after_default() {
		wpex_footer_bottom();
	}
}

/**
	Wrap: After
**/
if( ! function_exists( 'wpex_hook_wrap_after_default' ) ) {
	function wpex_hook_wrap_after_default() {
		wpex_toggle_bar();
	}
}