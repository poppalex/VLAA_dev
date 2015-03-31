<?php
/**
	Register Shortcode
**/
if( !function_exists('vcex_divider_shortcode') ) {
	function vcex_divider_shortcode( $atts ) {
		extract( shortcode_atts( array(
			'style'			=> 'solid',
			'margin_top'	=> '20px',
			'margin_bottom'	=> '20px',
			'class'			=> '',
			'icon'			=> 'None',
			'icon_color'	=> '#222',
			'icon_bg'		=> '',
			'icon_size'		=> '14px',
			'icon_padding'	=> '',
			'unique_id'		=> '',
		),
		$atts ) );

		
		// Main Style
		$add_style = array();
		
		if( $margin_bottom ) {
			$add_style[] = 'margin-bottom: '. $margin_bottom .';';
		}
		
		if ( $margin_top ) {
			$add_style[] = 'margin-top: '. $margin_top .';';
		}
		
		$add_style = implode('', $add_style);

		if ( $add_style ) {
			$add_style = wp_kses( $add_style, array() );
			$add_style = ' style="' . esc_attr($add_style) . '"';
		}
		
		// Icon Style
		$icon_style = array();
		
		if ( $icon ) {
		
			if( $icon_size ) {
				$icon_style[] = 'font-size: '. $icon_size .';';
			}
			
			if ( $icon_color && $icon_color !== '#000' ) {
				$icon_style[] = 'color: '. $icon_color .';';
			}

			if ( $icon_bg ) {
				$icon_style[] = 'background-color: '. $icon_bg .';';
			}

			if ( $icon_padding ) {
				$icon_style[] = 'padding: '. $icon_padding .';';
			}
			
			$icon_style = implode('', $icon_style);
		
		}

		if ( $icon_style ) {
			$icon_style = wp_kses( $icon_style, array() );
			$icon_style = ' style="' . esc_attr($icon_style) . '"';
		}		
		
		
		// Output
		if ( $icon && 'None' != $icon && 'none' !== $icon ) {
		$output = '<div class="vcex-divider-with-icon '. $style .' '. $class .'" '.$add_style.'><span class="fa fa-'. $icon .'" '. $icon_style .'></span></div>';
		} else {
			$output = '<hr class="vcex-divider '. $style .' '. $class .'" '.$add_style.' />';
		}
		
		return $output;
	}
}
add_shortcode( 'vcex_divider', 'vcex_divider_shortcode' );


/**
	Add To Visual Composer
**/
add_action( 'init', 'vcex_divider_shortcode_vc_map' );
if ( ! function_exists( 'vcex_divider_shortcode_vc_map' ) ) {
	function vcex_divider_shortcode_vc_map() {
		vc_map( array(
			"name"					=> __( "Divider", 'wpex' ),
			"description"			=> __( "Line seperator", 'wpex' ),
			"base"					=> "vcex_divider",
			"class"					=> "",
			'admin_enqueue_js'		=> "",
			'admin_enqueue_css'		=> "",
			"icon" 					=> "icon-wpb-vcex-divider",
			'category'				=> WPEX_THEME_BRANDING,
			"params"				=> array(
				array(
					"type"			=> "dropdown",
					"admin_label"	=> true,
					"class"			=> "",
					"heading"		=> __( "Style", 'wpex' ),
					"param_name"	=> "style",
					"value"			=> array(
						__( "Solid", "wpex")	=> "solid",
						__( "Dashed", "wpex" )	=> "dashed",
						__( "Dotted", "wpex" )	=> "dotted",
						__( "Double", "wpex" )	=> "double",
					),
					"description"	=> __( "Select your divider style.", 'wpex' ),
				),
				array(
					"type"			=> "dropdown",
					"class"			=> "",
					"heading"		=> __( "Icon", 'wpex' ),
					"param_name"	=> "icon",
					"admin_label"	=> true,
					"description"	=> sprintf( __( 'Select a FontAwesome icon. See all the icons at %s', 'wpex' ), '<a href="http://fortawesome.github.io/Font-Awesome/icons/" target="_blank">FontAwesome</a>' ),
					"value"			=> wpex_get_awesome_icons(),
				),
				array(
					"type"			=> "colorpicker",
					"class"			=> "",
					"heading"		=> __( "Icon Color", 'wpex' ),
					"param_name"	=> "icon_color",
					"value"			=> "#000",
					"dependency"	=> Array(
						'element'	=> "icon",
						'not_empty'	=> true,
					)
				),
				array(
					"type"			=> "colorpicker",
					"class"			=> "",
					"heading"		=> __( "Icon Background", 'wpex' ),
					"param_name"	=> "icon_bg",
					"value"			=> "",
					"dependency"	=> Array(
						'element'	=> "icon",
						'not_empty'	=> true,
					)
				),
				array(
					"type"			=> "textfield",
					"class"			=> "",
					"heading"		=> __( "Icon Size", 'wpex' ),
					"param_name"	=> "icon_size",
					"value"			=> "14px",
					"dependency"	=> Array(
						'element'	=> "icon",
						'not_empty' => true
					),
					"description"	=> __( "Enter a custom icon size in pixels for your divider icon.", 'wpex' ),
				),
				array(
					"type"			=> "textfield",
					"class"			=> "",
					"heading"		=> __( "Icon Padding", 'wpex' ),
					"param_name"	=> "icon_padding",
					"value"			=> "",
					"dependency"	=> Array(
						'element'	=> "icon",
						'not_empty'	=> true
					),
					"description"	=> __( "Alter the default padding on the icon (top, right, bottom, left).", 'wpex' ),
				),
				array(
					"type"			=> "textfield",
					"class"			=> "",
					"heading"		=> __( "Margin Top", 'wpex' ),
					"param_name"	=> "margin_top",
					"value"			=> "20px",
					"description"	=> __( "Enter a top margin for your divider in pixels.", 'wpex' ),
				),
				array(
					"type"			=> "textfield",
					"class"			=> "",
					"heading"		=> __( "Margin Bottom", 'wpex' ),
					"param_name"	=> "margin_bottom",
					"value"			=> "20px",
					"description"	=> __( "Enter a bottom margin for your divider in pixels.", 'wpex' ),
				),
			)
		) );
	}
}