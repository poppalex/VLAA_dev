<?php
/**
	Register Shortcode
**/
if( !function_exists('vcex_button_shortcode') ) {
	function vcex_button_shortcode( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'layout'			=> '',
			'style'				=> 'graphical',
			'color'				=> 'blue',
			'url'				=> 'http://www.vcexplorer.com',
			'title'				=> __('Visit Site', 'wpex' ),
			'target'			=> 'self',
			'size'				=> 'normal',
			'font_weight'		=> '',
			'font_size'			=> '',
			'align'				=> 'alignleft',
			'rel'				=> '',
			'border_radius'		=> '',
			'class'				=> '',
			'icon_left'			=> '',
			'icon_right'		=> '',
			'css_animation'		=> '',
		), $atts ) );
		
		// Load required scripts
		if ( ( $icon_left && $icon_left !== 'none' ) || (  $icon_right && $icon_right !== 'none' ) ) {
			wp_enqueue_style('vcex_shortcode_font_awesome');
		}
		
		// Rel
		$rel = ( $rel !== 'none' ) ? 'rel="'.$rel.'"' : NULL;
		
		// Animation
		$css_animation_classes = '';
		if ( $css_animation !== '' ) {
			$css_animation_classes = 'wpb_animate_when_almost_visible wpb_'. $css_animation .'';
		}
		
		// Custom Style
		$inline_style = array();
		
		if ( $font_size ) {
			$inline_style[] = 'font-size: '. $font_size .';';
		}

		if ( $font_weight ) {
			$inline_style[] = 'font-weight: '. $font_weight .';';
		}
		
		if ( $border_radius ) {
			$inline_style[] = 'border-radius: '. $border_radius .';';
		}
		
		$inline_style = implode('', $inline_style);
		
		if ( $inline_style ) {
			$inline_style = wp_kses( $inline_style, array() );
			$inline_style = ' style="' . esc_attr($inline_style) . '"';
		}
		
		// Display Button
		$output= NULL;
		if ( $align == 'center' ) {
			$output.= '<div class="textcenter">';
		}
		$output.= '<a href="' . $url . '" class="vcex-button vcex-button-'. $layout .' '. $style .' align-'. $align .' '. $size .' ' . $color . ' '. $class .' '. $css_animation_classes .'" target="_'.$target.'" title="'. $title .'" '. $inline_style .' '. $rel .'>';
			$output.= '<span class="vcex-button-inner" '. $inline_style .'>';
				if ( $icon_left && $icon_left !== 'none' ) $output.= '<i class="vcex-button-icon-left fa fa-'. $icon_left .'"></i>';
				$output.= $content;
				if ( $icon_right && $icon_right !== 'none' ) $output.= '<i class="vcex-button-icon-right fa fa-'. $icon_right .'"></i>';
			$output.= '</span>';			
		$output.= '</a>';
		if ( $align == 'center' ) {
			$output.= '</div>';
		}
		return $output;
	}
}
add_shortcode( 'vcex_button', 'vcex_button_shortcode' );



/**
	Extend Visual Composer
**/
add_action( 'init', 'vcex_button_shortcode_vc_map' );
if ( ! function_exists( 'vcex_button_shortcode_vc_map' ) ) {
	function vcex_button_shortcode_vc_map() {
		vc_map( array(
			"name"					=> __( "Total Button", 'wpex' ),
			"description"			=> __( "Eye catching button", 'wpex' ),
			"base"					=> "vcex_button",
			'category'				=> WPEX_THEME_BRANDING,
			"class"					=> "",
			'admin_enqueue_js'		=> "",
			'admin_enqueue_css'		=> "",
			"icon" 					=> "icon-wpb-vcex-button",
			"params"				=> array(
				array(
					"type"			=> "textfield",
					"heading"		=> __( "URL", 'wpex' ),
					"param_name"	=> "url",
					"value"			=> "http://www.google.com/",
					"description"	=> __( "Enter a target URL for your button. Don't forget the http:// at the front.", 'wpex' ),
				),
				array(
					"type"			=> "textfield",
					"heading"		=> __( "Button Text", 'wpex' ),
					"param_name"	=> "content",
					"admin_label"	=> true,
					"value"			=> "Button Text",
					"description"	=> __( "Your button Text.", 'wpex' ),
				),
				array(
					"type"			=> "textfield",
					"class"			=> "",
					"heading"		=> __( "Link Title", 'wpex' ),
					"param_name"	=> "title",
					"value"			=> "Visit Site",
					"description"	=> __( "Your button link title attribute.", 'wpex' ),
				),
				array(
					"type"			=> "dropdown",
					"heading"		=> __("CSS Animation", "wpex"),
					"param_name"	=> "css_animation",
					"value"			=> array(
					__("No", "wpex")						=> '',
						__("Top to bottom", "wpex")			=> "top-to-bottom",
						__("Bottom to top", "wpex")			=> "bottom-to-top",
						__("Left to right", "wpex")			=> "left-to-right",
						__("Right to left", "wpex")			=> "right-to-left",
						__("Appear from center", "wpex")	=> "appear"),
					"description"	=> __("Select animation type if you want this element to be animated when it enters into the browsers viewport. Note: Works only in modern browsers.", "wpex")
				),
				array(
					"type"			=> "dropdown",
					"heading"		=> __( "Button Style", 'wpex' ),
					"param_name"	=> "style",
					"value"			=> array(
						__( "Graphical", "wpex")	=> "graphical",
						__( "Clean", "wpex")		=> "clean",
						__( "Flat", "wpex" )		=> "flat",
						__( "3D", "wpex" )			=> "three-d",
						__( "Outline", "wpex" )		=> "outline",
					),
					"description"	=> __( "Select a style for this button.", 'wpex' ),
					'group'			=> __( 'Design', 'wpex' ),
				),

				array(
					"type"			=> "dropdown",
					"heading"		=> __("Layout", "wpex"),
					"param_name"	=> "layout",
					"value"			=> array(
						__("Default", "wpex") => '',
						__("Expanded (fit container)", "wpex") => "expanded",
					),
					"description"	=> __( "Select a layout style for this button.", 'wpex' ),
					'group'			=> __( 'Design', 'wpex' ),
				),
				array(
					"type"			=> "dropdown",
					"class"			=> "",
					"heading"		=> __( "Button Align", 'wpex' ),
					"param_name"	=> "align",
					"value"			=> array(
						__( "Left", "wpex")		=> "left",
						__( "Right", "wpex")		=> "right",
						__( "Center", "wpex" )	=> "center",
					),
					"description"	=> __( 'Your button alignment', 'wpex' ),
					'group'			=> __( 'Design', 'wpex' ),
				),
				array(
					"type"			=> "dropdown",
					"heading"		=> __( "Button Color", 'wpex' ),
					"param_name"	=> "color",
					"value"			=> array(
						__( "Black", "wpex")	=> "black",
						__( "Blue", "wpex" )	=> "blue",
						__( "Brown", "wpex" )	=> "brown",
						__( "Grey", "wpex" )	=> "grey",
						__( "Green", "wpex" )	=> "green",
						__( "Gold", "wpex" )	=> "gold",
						__( "Orange", "wpex" )	=> "orange",
						__( "Pink", "wpex" )	=> "pink",
						__( "Purple", "wpex" )	=> "purple",
						__( "Red", "wpex" ) 	=> "red",
						__( "Rosy", "wpex" )	=> "rosy",
						__( "Teal", "wpex" )	=> "teal",
						__( "White", "wpex")	=> "white",
					),
					"description"	=> __( "Select a color for this button. Note: Custom colors aren't supported for several reasons.", 'wpex' ),
					'group'			=> __( 'Design', 'wpex' ),
				),
				array(
					"type"			=> "dropdown",
					"class"			=> "",
					"heading"		=> __( "Button Size", 'wpex' ),
					"param_name"	=> "size",
					"value"			=> array(
						__( "Small", "wpex")	=> "small",
						__( "Medium", "wpex" )	=> "medium",
						__( "Large", "wpex" )	=> "large",
					),
					"description"	=> __( "Your preferred button size. For more specific sizing you can alter the font size below.", 'wpex' ),
					'group'			=> __( 'Design', 'wpex' ),
				),
				array(
					"type"			=> "textfield",
					"class"			=> "",
					"heading"		=> __( "Custom Font Size", 'wpex' ),
					"param_name"	=> "font_size",
					"value"			=> "",
					"description"	=> __('Your button font size. Don\'t forget to enter em or px.','wpex'),
					'group'			=> __( 'Design', 'wpex' ),
				),
				array(
					"type"			=> "textfield",
					"class"			=> "",
					"heading"		=> __( "Custom Font Weight", 'wpex' ),
					"param_name"	=> "font_weight",
					"value"			=> "",
					"description"	=> __( "Your button font weight (100,200,300,400,600,700,900).", 'wpex' ),
					'group'			=> __( 'Design', 'wpex' ),
				),
				array(
					"type"			=> "textfield",
					"class"			=> "",
					"heading"		=> __( "Border Radius", 'wpex' ),
					"param_name"	=> "border_radius",
					"value"			=> "",
					"description"	=> __( 'Custom border radius. This gives your button "roundedness".', 'wpex' ),
					'group'			=> __( 'Design', 'wpex' ),
				),
				array(
					"type"			=> "dropdown",
					"class"			=> "",
					"heading"		=> __( "Link Target", 'wpex' ),
					"param_name"	=> "target",
					"value"			=> array(
						__( "Self", "wpex")		=> "self",
						__( "Blank", "wpex" )	=> "blank",
					),
					"description"	=> __( 'Your link target. Choose self to open the link in the same browser tab and blank to open in a new tab.', 'wpex' ),
					'group'			=> __( 'Attributes', 'wpex' ),
				),
				array(
					"type"			=> "dropdown",
					"class"			=> "",
					"heading"		=> __( "Link Rel", 'wpex' ),
					"param_name"	=> "rel",
					"value"			=> array(
						__( "None", "wpex")		=> "none",
						__( "Nofollow", "wpex" )	=> "nofollow",
					),
					"description"	=> __( 'Select a rel attribute for your link.', 'wpex' ),
					'group'			=> __( 'Attributes', 'wpex' ),
				),
				array(
					"type"			=> "dropdown",
					"class"			=> "",
					"heading"		=> __( "Icon Left", 'wpex' ),
					"param_name"	=> "icon_left",
					"description"	=> sprintf( __( 'Icon to the left of your button text. See all the icons at %s', 'wpex' ), '<a href="http://fortawesome.github.io/Font-Awesome/icons/" target="_blank">FontAwesome</a>' ),
					"value"			=> wpex_get_awesome_icons(),
					'group'			=> __( 'Icons', 'wpex' ),
				),
				array(
					"type"			=> "dropdown",
					"class"			=> "",
					"heading"		=> __( "Icon Right", 'wpex' ),
					"param_name"	=> "icon_right",
					"description"	=> sprintf( __( 'Icon to the right of your button text. See all the icons at %s', 'wpex' ), '<a href="http://fortawesome.github.io/Font-Awesome/icons/" target="_blank">FontAwesome</a>' ),
					"value"			=> wpex_get_awesome_icons(),
					'group'			=> __( 'Icons', 'wpex' ),
				),
			)
		) );
	}
}