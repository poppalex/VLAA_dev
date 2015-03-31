<?php
/**
	Register shortcode
**/
if( !function_exists('vcex_spacing_shortcode') ) {
	function vcex_spacing_shortcode( $atts ) {
		extract( shortcode_atts( array(
			'size'	=> '20px',
			'class'	=> '',
		),
		$atts ) );
		if ( wpex_is_front_end_composer() ) {
			return '<div class="vc-spacing-shortcode vcex-spacing '. $class .'" style="height: '. $size .'"></div>';
		} else {
			return '<hr class="vcex-spacing '. $class .'" style="height: '. $size .'" />';
		}
	}
}
add_shortcode( 'vcex_spacing', 'vcex_spacing_shortcode' );


/**
	Add to visual composer
**/
add_action( 'init', 'vcex_spacing_shortcode_vc_map' );
if ( ! function_exists( 'vcex_spacing_shortcode_vc_map' ) ) {
	function vcex_spacing_shortcode_vc_map() {
		vc_map( array(
			"name"					=> __( "Spacing", 'vces' ),
			"description"			=> __( "Adds spacing anywhere you need it.", 'wpex' ),
			"base"					=> "vcex_spacing",
			'category'				=> WPEX_THEME_BRANDING,
			"icon"					=> "icon-wpb-vcex-spacing",
			"params"				=> array(
				array(
					"type"			=> "textfield",
					"admin_label"	=> true,
					"class"			=> "",
					"heading"		=> __( "Spacing", 'wpex' ),
					"param_name"	=> "size",
					"value"			=> "30px",
					"description"	=> __( "Enter a height in pixels for your spacing.", 'wpex' )
				),
				array(
					"type"			=> "textfield",
					"admin_label"	=> true,
					"class"			=> "",
					"heading"		=> __( "Clasname", 'wpex' ),
					"param_name"	=> "class",
					"value"			=> "",
					"description"	=> __( "Give your spacing module a classname for styling purposes.", 'wpex' )
				),
			)
		) );
	}
}