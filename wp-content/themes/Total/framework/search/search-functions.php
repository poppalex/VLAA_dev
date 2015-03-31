<?php
/*
 * Core search functions
 *
 * @package WordPress
 * @subpackage Total
 * @since 1.1
*/


// Not needed in admin
if ( is_admin() ) return;

// Check if search icon should be in the nav
if ( ! function_exists( 'wpex_search_in_menu' ) ) {
	function wpex_search_in_menu() {
		if ( !wpex_option( 'main_search', '1' ) ) return false;
		$header_style = wpex_option( 'header_style', 'one' );
		if ( 'two' == $header_style ) {
			return false;
		} else {
			return true;
		}
	} // End function
} // Enf if function_exists check