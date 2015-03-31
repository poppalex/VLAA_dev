<?php
/**
	Register Shortcode
**/
if( !function_exists('vcex_list_item_shortcode') ) {
	function vcex_list_item_shortcode( $atts, $content = NULL ) {
		extract( shortcode_atts( array(
			'style'			=> '',
			'icon'			=> '',
			'color'			=> '#fff',
			'font_color'	=> '',
			'font_size'		=> '',
			'icon_size'		=> '',
			'text_align'	=> 'textleft',
			'margin_right'	=> '',
			'css_animation'	=> '',
			'font_size'		=> '',
			'css_animation'	=> '',
			'url'			=> '',
			'url_target'	=> 'self',
		),
		$atts ) );
		
		// Main Styles
		$add_style = array();
		
		if( $font_size ) {
			$add_style[] = 'font-size:'. $font_size .';';
		}
		
		if ( $font_color ) {
			$add_style[] = 'color: '. $font_color .';';
		}
		
		$add_style = implode('', $add_style);

		if ( $add_style ) {
			$add_style = wp_kses( $add_style, array() );
			$add_style = ' style="' . esc_attr($add_style) . '"';
		}
		
		// Icon margin right
		if ( $margin_right ) {
			$margin_right = 'margin-right:'. intval($margin_right) .'px;';
		}

		// Icon font size
		if ( $icon_size ) {
			$icon_size = 'font-size:'. intval($icon_size) .'px;';
		}
		
		// CSS animations
		$css_animation_classes = '';
		if ( $css_animation !== '' ) {
			$css_animation_classes = 'wpb_animate_when_almost_visible wpb_'. $css_animation .'';
		}
		
		// Output
		$output ='<div class="vcex-list_item '. $css_animation_classes .' '. $text_align .'" '. $add_style .'>';
			if ( $url ) {
				$output .= '<a href="'. esc_url($url) .'" title="'. wp_strip_all_tags($content) .'" target="_'. $url_target .'">';
			}
			$output .= '<span class="fa fa-'. $icon .'" style="color:'. $color .';'. $margin_right . $icon_size .'"></span>';
			$output .= do_shortcode( $content );
			if ( $url ) {
				$output .= '</a>';
			}
		$output .= '</div>';
		
		return $output;
	}
}
add_shortcode('vcex_list_item', 'vcex_list_item_shortcode');



/**
	Add To Visual Composer
**/
add_action( 'init', 'vcex_list_item_shortcode_vc_map' );
if ( ! function_exists( 'vcex_list_item_shortcode_vc_map' ) ) {
	function vcex_list_item_shortcode_vc_map() {
		vc_map( array(
			"name"					=> __( "List Item", 'wpex' ),
			"description"			=> __( "Font Icon list item", 'wpex' ),
			"base"					=> "vcex_list_item",
			"class"					=> "",
			'admin_enqueue_js'		=> "",
			'admin_enqueue_css'		=> "",
			"icon" 					=> "icon-wpb-vcex-list_item",
			'category'				=> WPEX_THEME_BRANDING,
			"params"				=> array(
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
					"type"			=> "dropdown",
					"heading"		=> __("CSS Animation", "wpex"),
					"param_name"	=> "css_animation",
					"value"			=> array(
							__("No", "wpex")				=> '',
						__("Top to bottom", "wpex")			=> "top-to-bottom",
						__("Bottom to top", "wpex")			=> "bottom-to-top",
						__("Left to right", "wpex")			=> "left-to-right",
						__("Right to left", "wpex")			=> "right-to-left",
						__("Appear from center", "wpex")	=> "appear"),
					"description"	=> __("Select animation type if you want this element to be animated when it enters into the browsers viewport. Note: Works only in modern browsers.", "wpex"),
					"dependency"	=> Array('element'	=> "icon", 'not_empty' => true ),
					'group'			=> __( "Design", 'wpex' ),
				),
				array(
					"type"			=> "colorpicker",
					"class"			=> "",
					"heading"		=> __( "Icon Color", 'wpex' ),
					"param_name"	=> "color",
					"value"			=> "#7dbd21",
					"dependency"	=> Array('element'	=> "icon", 'not_empty' => true ),
					"description"	=> __( "Select your icon color.", 'wpex' ),
					'group'			=> __( "Design", 'wpex' ),
				),
				array(
					"type"			=> "textfield",
					"class"			=> "",
					"heading"		=> __( "Icon Right Margin", 'wpex' ),
					"param_name"	=> "margin_right",
					"value"			=> "",
					"description"	=> __( "Enter a custom right side margin for your icon. Example: 10px", 'wpex' ),
					"dependency"	=> Array('element'	=> "icon", 'not_empty' => true ),
					'group'			=> __( "Design", 'wpex' ),
				),
				array(
					"type"			=> "colorpicker",
					"class"			=> "",
					"heading"		=> __( "Font Color", 'wpex' ),
					"param_name"	=> "font_color",
					"value"			=> "",
					"dependency"	=> Array('element'	=> "icon", 'not_empty' => true ),
					"description"	=> __( "Select a custom font color for the list item.", 'wpex' ),
					'group'			=> __( "Design", 'wpex' ),
				),
				array(
					"type"			=> "textfield",
					"class"			=> "",
					"heading"		=> __( "Custom Font Size", 'wpex' ),
					"param_name"	=> "font_size",
					"value"			=> "",
					"description"	=> __( "Enter a custom font size in pixels, such as 18px (optional). This will alter the icon and text size.", 'wpex' ),
					'group'			=> __( "Design", 'wpex' ),
				),
				array(
					"type"			=> "textfield",
					"class"			=> "",
					"heading"		=> __( "Custom Icon Size", 'wpex' ),
					"param_name"	=> "icon_size",
					"value"			=> "",
					"description"	=> __( "Enter a custom font size in pixels, such as 18px (optional). This will alter the icon size.", 'wpex' ),
					'group'			=> __( "Design", 'wpex' ),
				),
				array(
					"type"			=> "dropdown",
					"class"			=> "",
					"heading"		=> __( "Text Align", 'wpex' ),
					"param_name"	=> "text_align",
					"value"			=> array(
						__('Left','wpex')	=> 'textleft',
						__('Center','wpex')	=> 'textcenter',
						__('Right','wpex')	=> 'textright',
					),
					"description"	=> __( "Select your preferred text alignment.", 'wpex' ),
					'group'			=> __( "Design", 'wpex' ),
				),
				array(
					"type"			=> "textfield",
					"class"			=> "",
					"heading"		=> __( "Content", 'wpex' ),
					"param_name"	=> "content",
					"value"			=> __( 'This is a pretty list item', 'wpex' ),
					"description"	=> __( "Insert your unordered list here.", 'wpex' ),
				),
				array(
					"type"			=> "textfield",
					"class"			=> "",
					"heading"		=> __( "Link", 'wpex' ),
					"param_name"	=> "url",
					"value"			=> '',
					"description"	=> __( "Add a URL to your list item.", 'wpex' ),
					'group'			=> __( "Link", 'wpex' ),
				),
				array(
					"type"			=> "dropdown",
					"class"			=> "",
					"heading"		=> __( "Link Target", 'wpex' ),
					"param_name"	=> "url_target",
					"value"			=> array(
						__( "Self", "wpex")		=> "self",
						__( "Blank", "wpex" )	=> "blank",
					),
					"description"	=> __( 'Your link target. Choose self to open the link in the same browser tab and blank to open in a new tab.', 'wpex' ),
					'group'			=> __( "Link", 'wpex' ),
				),
			)
		) );
	}
}