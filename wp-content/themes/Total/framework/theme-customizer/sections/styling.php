<?php
/**
 * Loops through and adds the color options to the theme customizer
 *
 * @package WordPress
 * @subpackage Total
 * @since Total 1.0
 */


/**
	Add Styling Options To The Theme Customizer
**/
if ( ! function_exists( 'wpex_customizer_styling_options' ) ) {
	function wpex_customizer_styling_options() {
		$styling_options = array();
		global $wpex_redux_framework_class;
		if ( ! method_exists( $wpex_redux_framework_class, 'getReduxSections' ) ) return;
		$sections = $wpex_redux_framework_class->getReduxSections();
		if ( isset ( $sections ) ) {
			foreach ($sections as $section) {
				if( isset( $section['fields'] ) ) {
					$section_id = isset( $section['id'] ) ? $section['id'] : '';
					if ( 'styling' == $section_id || 'footer' == $section_id ) {
						foreach( $section['fields'] as $field ) {
							if ( !isset( $field['theme_customizer'] ) || false != $field['theme_customizer'] ) {
								// Colors
								if ( $field['type'] == 'color' ) {
									$target_element = isset($field['target_element']) ? $field['target_element'] : '';
									$target_style = isset($field['target_style']) ? $field['target_style'] : '';
									$styling_options[] = array(
										'title'				=> $field['title'],
										'default'			=> $field['default'],
										'type'				=> $field['type'],
										'id'				=> $field['id'],
										'target_element'	=> $target_element,
										'target_style'		=> $target_style,
									);
								}
							}
						}
					}
				}
			}
			// Return new array
			return $styling_options;
		}
	}
}


/**
	Create Customizer Options
**/
if ( !function_exists( 'wpex_customizer_colors') && function_exists( 'wpex_customizer_styling_options' ) ) {

	function wpex_customizer_colors( $wp_customize ) {

		// Get Color Options
		$styling_options = wpex_customizer_styling_options();
		if ( ! isset( $styling_options ) ) return;

		$admin_styling_url = admin_url( 'admin.php?page=wpex_options&tab=6' );

		// Theme Design Section
		$wp_customize->add_section( 'wpex_theme_colors' , array(
			'title'			=> __( 'Core Theme Colors', 'wpex' ),
			'priority'		=> 200,
			'description'	=> sprintf( __( 'This section includes the main color options for your theme. For all styling options please visit the <a href="%s" target="_blank">theme panel</a>.', 'wpex' ), esc_url( $admin_styling_url ) ),
		) );

		// Set count variable to be used for priority
		$count='';
		// Loop through color options and add a theme customizer setting for it
		foreach( $styling_options as $option ) {
			// Option ID
			$option_id = 'wpex_options['. $option['id'] .']';
			// Counter for priority
			$count++;
			// Section to add options too
			$section = isset($option['customizer_section']) ? $option['customizer_section'] : 'theme';
			// Color settings
			if ( 'color' == $option['type'] ) {
				$wp_customize->add_setting( $option_id, array(
					'type'			=> 'option',
					'capabilities'	=> 'manage_theme_options',
					'default'		=> $option['default'],
					'transport'		=> 'refresh',
				) );
				$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $option_id, array(
					'label'		=> $option['title'],
					'section'	=> 'wpex_'. $section .'_colors',
					'settings'	=> $option_id,
					'priority'	=> $count,
				) ) );
			}
		}
	} // End function
} // End function_exists check

add_action( 'customize_register', 'wpex_customizer_colors' );