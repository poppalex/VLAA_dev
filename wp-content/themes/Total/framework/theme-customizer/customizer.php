<?php
/**
 * Add support for the Theme Customizer
 *
 * @package WordPress
 * @subpackage Total
 * @since Total 1.0
 */


// Include Customizer Sections
require_once( WPEX_FRAMEWORK_DIR .'theme-customizer/sections/styling.php' );


// Add JS for customizer settings
if ( ! function_exists( 'wpex_customizer_live_preview' ) ) {
	function wpex_customizer_live_preview() {
		wp_enqueue_script( 'wpex-themecustomizer', WPEX_JS_DIR_URI .'theme-customizer.js', array( 'jquery','customize-preview' ), '', true );
		wp_localize_script( 'wpex-themecustomizer', 'wpexLocalize', array( 'skinDir' => get_template_directory_uri() .'/skins/' ) );
	}
}
add_action( 'customize_preview_init', 'wpex_customizer_live_preview' );