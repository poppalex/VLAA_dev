<?php
/**
 * Flat Skin Class
 *
 * @package WordPress
 * @subpackage Total
 * @since Total 1.3
*/


if ( !class_exists( "Total_Flat_Skin" ) ) {

	class Total_Flat_Skin {

		// Constructor
		function __construct() {
			add_action( 'wp_enqueue_scripts', array( &$this, 'load_styles') );
			//add_filter( 'wpex_redux_sections', array( &$this, 'add_redux_options') );
		}

		// Load Styles
		public function load_styles() {
			if ( function_exists('visual_composer_extension_run') ) {
				wp_enqueue_style( 'flat-skin', WPEX_SKIN_DIR_URI .'/flat/flat-style.css', array( 'wpex-style', 'vcex-composer-extend' ), '1.0', 'all' );
			} else {
				wp_enqueue_style( 'flat-skin', WPEX_SKIN_DIR_URI .'/flat/flat-style.css', array( 'wpex-style' ), '1.0', 'all' );
			}
		}

		// Add new theme options
		public function add_redux_options( $sections ) {
			$sections['flat_skin'] = array(
				'id'			=> 'flat_skin',
				'title'			=> __( 'Flat Skin', 'wpex' ),
				'header'		=> '',
				'desc'			=> '',
				'icon_class'	=> 'el-icon-large',
				'icon'			=> 'el-icon-resize-small',
				'submenu'		=> true,
				'fields'		=> array(
				)
			);
			return $sections;
		}

	}

}

// Start Class
$wpex_skin_class = new Total_Flat_Skin();