<?php
/**
 * Agent Skin Class
 *
 * @package WordPress
 * @subpackage Total
 * @since Total 1.3
*/


if ( !class_exists( "Total_Agent_Skin" ) ) {

	class Total_Agent_Skin {

		// Constructor
		function __construct() {
			add_action( 'wp_enqueue_scripts', array( &$this, 'load_styles') );
		}

		// Load Styles
		public function load_styles() {
			if ( function_exists('visual_composer_extension_run') ) {
				wp_enqueue_style( 'agent-skin', WPEX_SKIN_DIR_URI .'/agent/agent-style.css', array( 'wpex-style', 'vcex-composer-extend' ), '1.0', 'all' );
			} else {
				wp_enqueue_style( 'agent-skin', WPEX_SKIN_DIR_URI .'/agent/agent-style.css', array( 'wpex-style' ), '1.0', 'all' );
			}
		}

	}

}

// Start Class
$wpex_skin_class = new Total_Agent_Skin();