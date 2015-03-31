<?php
/**
 * Gaps Skin Class
 *
 * @package WordPress
 * @subpackage Total
 * @since Total 1.3
*/


if ( !class_exists( "Total_Gaps_Skin" ) ) {

	class Total_Gaps_Skin {
		
		// Constructor
		function __construct() {
			add_action( 'wp_enqueue_scripts', array( &$this, 'load_styles') );
		}

		// Load Styles
		public function load_styles() {
			if ( function_exists('visual_composer_extension_run') ) {
				wp_enqueue_style( 'gaps-skin', WPEX_SKIN_DIR_URI .'/gaps/gaps-style.css', array( 'wpex-style', 'vcex-composer-extend' ), '1.0', 'all' );
			} else {
				wp_enqueue_style( 'gaps-skin', WPEX_SKIN_DIR_URI .'/gaps/gaps-style.css', array( 'wpex-style' ), '1.0', 'all' );
			}
		}

	}

}

// Start Class
$wpex_skin_class = new Total_Gaps_Skin();