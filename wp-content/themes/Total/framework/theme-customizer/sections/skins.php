<?php
/**
 * Adds Skins option to Theme Customizer
 *
 * @package WordPress
 * @subpackage Total
 * @since Total 1.0
 */


/**
	Create Customizer Options
**/
if ( !function_exists( 'wpex_customizer_skins') && function_exists( 'wpex_skins' ) ) {

	function wpex_customizer_skins( $wp_customize ) {
		// Skins
		$total_skins = wpex_skins();
		if ( ! isset( $total_skins ) ) {
			return;
		}

		$skins = array();
		foreach ( $total_skins as $key => $value ) {
			$skins[$key] = $total_skins[$key]['name'];
		}

		// Add skin customizer section
		$wp_customize->add_section( 'wpex_theme_skin' , array(
			'title'			=> __( 'Main Skin', 'wpex' ),
			'priority'		=> '0',
			'description'	=> __( 'Select your default theme skin.', 'wpex' ),
		) );

		// Add select to skin customizer section
		$wp_customize->add_setting( 'wpex_options[site_theme]', array(
			'type'			=> 'option',
			'capabilities'	=> 'manage_theme_options',
			'default'		=> 'base',
			'transport'		=> 'postMessage',
		) );
		$wp_customize->add_control( 'wpex_options[site_theme]', array(
			'label'		=> __( 'Skin Select', 'wpex' ),
			'section'	=> 'wpex_theme_skin',
			'settings'	=> 'wpex_options[site_theme]',
			'type'		=> 'select',
			'choices'	=> $skins,
		) );

	} // End function

} // End function_exists check

add_action( 'customize_register', 'wpex_customizer_skins' );
