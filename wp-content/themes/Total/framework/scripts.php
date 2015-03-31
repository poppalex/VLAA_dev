<?php
/**
 * This file loads css and js for our theme and other script related functions
 *
 * @package Total
 * @author Alexander Clarke
 * @copyright Copyright (c) 2014, Symple Workz LLC
 * @link http://www.wpexplorer.com
 * @since Total 1.0
*/

/**
 * Enqueues all CSS and JS for the theme
 *
 * @package WordPress
 * @subpackage Total
 * @since Total 1.5
*/
if ( ! function_exists( 'wpex_load_scripts' ) ) {
	function wpex_load_scripts() {
		
		
		/*******************
		/*** CSS
		/*******************/
		
		// Load Visual composer CSS at top of site
		if ( function_exists( 'vc_map' ) && !is_admin() ) {
			wp_enqueue_style( 'js_composer_front' );
		}

		// Minified CSS
		if ( wpex_supports( 'minify', 'css' ) && wpex_option( 'minify_css' ) ) {
			wp_enqueue_style( 'wpex-style', get_stylesheet_directory_uri() .'/style-min.css', false, '1.41' );
		}
		// Unminified CSS
		else {
			wp_enqueue_style( 'wpex-style', get_stylesheet_uri() );
			if ( class_exists('Woocommerce') ) {
				wp_enqueue_style( 'wpex-woocommerce', WPEX_CSS_DIR_UIR .'woocommerce.css' );
			}
			if( wpex_option( 'responsive', '1' ) && !wpex_is_front_end_composer() ) {
				wp_enqueue_style( 'wpex-responsive', WPEX_CSS_DIR_UIR .'responsive.css', array( 'wpex-style' ) );
			}
		}

		// Remove scripts
		wp_deregister_style( 'js_composer_custom_css' );

		/*******************
		/*** Javascript
		/*******************/
		
		// Add scripts
		wp_enqueue_script( 'jquery' );
		if ( wpex_option( 'retina', '1' ) == '1' ) {
			wp_enqueue_script('retina', WPEX_JS_DIR_URI .'/plugins/retina.js', array('jquery'), '0.0.2', true );
		}
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script('comment-reply');
		}

		// Remove JS
		wp_dequeue_script( 'flexslider' );
		wp_deregister_script( 'flexslider' );

		// Load Total scripts
		if ( wpex_supports( 'minify', 'js' ) && wpex_option( 'minify_js', '1' ) ) {
			// Load super minified total js
			wp_enqueue_script( 'total-min', WPEX_JS_DIR_URI .'total-min.js', array( 'jquery' ), '', true );
		} else {
			// Load all non-minified js plugins
			wp_enqueue_script( 'wpex-superfish', WPEX_JS_DIR_URI .'plugins/superfish.js', array( 'jquery' ), '', true );
			wp_enqueue_script( 'wpex-supersubs', WPEX_JS_DIR_URI .'plugins/supersubs.js', array( 'jquery' ), '', true );
			wp_enqueue_script( 'wpex-hoverintent', WPEX_JS_DIR_URI .'plugins/hoverintent.js', array( 'jquery' ), '', true );
			wp_enqueue_script( 'wpex-sticky', WPEX_JS_DIR_URI .'plugins/sticky.js', array( 'jquery' ), '', true );
			wp_enqueue_script( 'wpex-tipsy', WPEX_JS_DIR_URI .'plugins/tipsy.js', array( 'jquery' ), '', true );
			wp_enqueue_script( 'wpex-waypoints', WPEX_JS_DIR_URI .'plugins/waypoints.js', array( 'jquery' ), '', true );
			wp_enqueue_script( 'wpex-magnific-popup', WPEX_JS_DIR_URI .'plugins/magnific-popup.js', array( 'jquery' ), '', true );
			wp_enqueue_script( 'wpex-scrollto', WPEX_JS_DIR_URI .'plugins/scrollto.js', array( 'jquery' ), '', true );
			wp_enqueue_script( 'wpex-images-loaded', WPEX_JS_DIR_URI .'plugins/images-loaded.js', array( 'jquery' ), '', true );
			wp_enqueue_script( 'wpex-isotope', WPEX_JS_DIR_URI .'plugins/isotope.js', array( 'jquery' ), '', true );
			wp_enqueue_script( 'wpex-leanner-modal', WPEX_JS_DIR_URI .'plugins/leanner-modal.js', array( 'jquery' ), '', true );
			wp_enqueue_script( 'wpex-infinite-scroll', WPEX_JS_DIR_URI .'plugins/infinite-scroll.js', array( 'jquery' ), '', true );
			wp_enqueue_script( 'wpex-flexslider', WPEX_JS_DIR_URI .'plugins/flexslider.js', array( 'jquery' ), '', true );
			wp_enqueue_script( 'wpex-masonry', WPEX_JS_DIR_URI .'plugins/masonry.js', array( 'jquery' ), '', true );
			wp_enqueue_script( 'wpex-touch-swipe', WPEX_JS_DIR_URI .'plugins/touch-swipe.js', array( 'jquery' ), '', true );
			wp_enqueue_script( 'wpex-count-to', WPEX_JS_DIR_URI .'plugins/count-to.js', array( 'jquery' ), '', true );
			wp_enqueue_script( 'wpex-caroufredsel', WPEX_JS_DIR_URI .'plugins/caroufredsel.js', array( 'jquery' ), '', true );
			wp_enqueue_script( 'wpex-appear', WPEX_JS_DIR_URI .'plugins/appear.js', array( 'jquery' ), '', true );
			wp_enqueue_script( 'wpex-sidr', WPEX_JS_DIR_URI .'plugins/sidr.js', array( 'jquery' ), '', true );
			wp_enqueue_script( 'wpex-custom-select', WPEX_JS_DIR_URI .'plugins/custom-select.js', array( 'jquery' ), '', true );
			wp_enqueue_script( 'wpex-scrolly', WPEX_JS_DIR_URI .'plugins/scrolly.js', array( 'jquery' ), '', true );
			wp_enqueue_script( 'wpex-match-height', WPEX_JS_DIR_URI .'plugins/match-height.js', array( 'jquery' ), '', true );
			// Init scripts
			wp_enqueue_script( 'wpex-global', WPEX_JS_DIR_URI .'global.js', array( 'jquery' ), '', true );
		}

	}
}
add_action( 'wp_enqueue_scripts', 'wpex_load_scripts' );

/**
 * Adds CSS for ie8
 *
 * @package WordPress
 * @subpackage Total
 * @since Total 1.5
*/
if ( !function_exists( 'wpex_ie8_css' ) ) {
	function wpex_ie8_css() {
		echo '<!--[if IE 8]><link rel="stylesheet" type="text/css" href="'. WPEX_CSS_DIR_UIR .'ie8.css" media="screen"><![endif]-->';
	}
}
add_action( 'wp_head', 'wpex_ie8_css' );

/**
 * Removes version scrips number if enabled
 *
 * @package WordPress
 * @subpackage Total
 * @since Total 1.5
*/
if ( !function_exists( 'wpex_html5' ) ) {
	function wpex_html5() {
		echo '<!--[if lt IE 9]>
			<script src="'.WPEX_JS_DIR_URI .'/plugins/html5.js"></script>
		<![endif]-->';
	}
}
add_action( 'wp_head', 'wpex_html5' );

/**
 * Removes version scrips number if enabled
 * for better Google Page Speed Scores
 *
 * @package WordPress
 * @subpackage Total
 * @since Total 1.5
*/
if ( ! function_exists( 'wpex_remove_wp_ver_css_js' ) ) {
	function wpex_remove_wp_ver_css_js( $src ) {
	if ( wpex_option( 'remove_scripts_version', '1' ) ) {
		if ( strpos( $src, 'ver=' ) ) {
			$src = remove_query_arg( 'ver', $src );
		}
	}
	return $src;
	}
}
add_filter( 'style_loader_src', 'wpex_remove_wp_ver_css_js', 9999 );
add_filter( 'script_loader_src', 'wpex_remove_wp_ver_css_js', 9999 );