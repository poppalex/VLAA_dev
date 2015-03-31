<?php
/**
 * Core theme functions - muy importante!
 *
 * @package Total
 * @author Alexander Clarke
 * @copyright Copyright (c) 2014, Symple Workz LLC
 * @link http://www.wpexplorer.com
 * @since Total 1.33
*/


/**
 * Setup the core theme for easy adding/removing of functions
 *
 * @package WordPress
 * @subpackage Total
 * @since Total 1.33
 * @return array $setup
*/
if ( !function_exists( 'wpex_global_config' ) ) {
	function wpex_global_config() {
		$setup = array(
			'primary'		=> array(
				'admin'			=> true,
				'post_types'	=> true,
			),
			'post_types'	=> array(
				'portfolio'		=> true,
				'staff'			=> true,
				'testimonials'	=> true,
			),
			'mce'			=> array(
				'fontselect'		=> true,
				'fontsizeselect'	=> true,
				'formats'			=> true,
				'shortcodes'		=> true,
			),
			'helpers'		=> array (
				'display_queries_memory'	=> false,
			),
			'minify'		=> array(
				'js'	=> true,
				'css'	=> true
			),
		);
		return apply_filters( 'wpex_global_config', $setup );
	}
}

/**
 * Checks for core functions upport
 *
 * @package WordPress
 * @subpackage Total
 * @since Total 1.33
 * @return bool
*/
function wpex_supports( $group, $feature ) {
	$setup = wpex_global_config();
	if( isset( $setup[$group][$feature] ) && $setup[$group][$feature] ) {
		return true;
	} else {
		return false;
	}
}

/**
 * Returns theme skins
 *
 * @package WordPress
 * @subpackage Total
 * @since Total 1.33
 * @return array $skins
*/
if ( !function_exists( 'wpex_skins' ) ) {
	function wpex_skins() {
		$skins = array(
			'base'				=> array (
				'core'			=> true,
				'name'			=> __( 'Base', 'wpex' ),
				'screenshot'	=> get_template_directory_uri() .'/images/base/base-screenshot.png',
			),
			'minimal-graphical'	=> array(
				'core'			=> true,
				'name'			=> __( 'Minimal Graphical', 'wpex' ),
				'screenshot'	=> WPEX_SKIN_DIR_URI .'/minimal-graphical/minimal-graphical-screenshot.png',
			),
			'agent'	=> array(
				'core'			=> true,
				'name'			=> __( 'Agent', 'wpex' ),
				'screenshot'	=> WPEX_SKIN_DIR_URI .'/agent/agent-screenshot.png',
			),
			'neat'	=> array(
				'core'			=> true,
				'name'			=> __( 'Neat', 'wpex' ),
				'screenshot'	=> WPEX_SKIN_DIR_URI .'/neat/neat-screenshot.png',
			),
			'flat'	=> array(
				'core'			=> true,
				'name'			=> __( 'Flat', 'wpex' ),
				'screenshot'	=> WPEX_SKIN_DIR_URI .'/flat/flat-screenshot.png',
			),
			'gaps'	=> array(
				'core'			=> true,
				'name'			=> __( 'Gaps', 'wpex' ),
				'screenshot'	=> WPEX_SKIN_DIR_URI .'/gaps/gaps-screenshot.png',
			),
		);
		$skins = apply_filters( 'wpex_skins', $skins );
		return $skins;
	}
}

/**
 * Returns theme custom post types
 *
 * @package WordPress
 * @subpackage Total
 * @since Total 1.33
 * @return array $post_types
*/
function wpex_theme_post_types() {
	$config = wpex_global_config();
	if ( ! wpex_supports( 'primary', 'post_types' ) ) {
		return array();
	}
	$post_types = $config['post_types'];
	if ( ! $post_types ) {
		return;
	}
	$post_types = array_filter( $post_types );
	$return = '';
	foreach( $post_types as $key => $value ) {
		$return[$key] = $key;
	}
	return apply_filters( 'wpex_theme_post_types', $return );
}

/**
 * Returns the 1st taxonomy of any taxonomy
 *
 * @package WordPress
 * @subpackage Total
 * @since Total 1.33
 * @return string
*/
if ( !function_exists( 'wpex_get_first_term' ) ) {
	function wpex_get_first_term( $post_id, $taxonomy = 'category' ) {
		if ( ! $post_id ) {
			return;
		}
		if ( ! taxonomy_exists( $taxonomy ) ) {
			return;
		}
		$terms = wp_get_post_terms( $post_id, $taxonomy );
		if ( ! empty( $terms ) ) { ?>
			<span><?php echo $terms[0]->name; ?></span>
		<?php
		}
	}
}

/**
 * Check if currently in front-end composer
 *
 * @package WordPress
 * @subpackage Total
 * @since Total 1.5
 * @return bool
*/
if ( !function_exists( 'wpex_is_front_end_composer' ) ) {
	function wpex_is_front_end_composer() {
		if ( ! function_exists('vc_is_inline') ) {
			return false;
		} elseif ( vc_is_inline() ) {
			return true;
		} else{
			return false;
		}
	}
}