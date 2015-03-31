<?php
/**
	Register Shortcode
**/
if( !function_exists('vcex_pricing_shortcode') ) {
	function vcex_pricing_shortcode( $atts, $content = null  ) {
		
		extract( shortcode_atts( array(
			'size'						=> 'one-half',
			'position'					=> '',
			'featured'					=> 'no',
			'plan'						=> 'Basic',
			'cost'						=> '$20',
			'per'						=> '',
			'button_url'				=> '',
			'button_text'				=> 'Purchase',
			'button_color'				=> 'blue',
			'button_target'				=> 'self',
			'button_rel'				=> 'nofollow',
			'button_border_radius'		=> '',
			'class'						=> '',
		), $atts ) );
		
		//set variables
		$featured_pricing = ( $featured == 'yes' ) ? 'featured' : NULL;
		$border_radius_style = ( $button_border_radius ) ? 'style="border-radius:'. $button_border_radius .'"' : NULL;
		
		//start content  
		$pricing_content ='';
		$pricing_content .= '<div class="vcex-pricing vcex-'. $size .' '. $featured_pricing .' vcex-column-'. $position. ' '. $class .'">';
			$pricing_content .= '<div class="vcex-pricing-header clr">';
				$pricing_content .= '<h5>'. $plan. '</h5>';
			$pricing_content .= '</div>';
			$pricing_content .= '<div class="vcex-pricing-cost clr">';
				$pricing_content .= '<div class="vcex-pricing-ammount">'. $cost .'</div><div class="vcex-pricing-per">'. $per .'</div>';
			$pricing_content .= '</div>';
			$pricing_content .= '<div class="vcex-pricing-content">';
				$pricing_content .= ''. $content. '';
			$pricing_content .= '</div>';
			if( $button_url ) {
				$pricing_content .= '<div class="vcex-pricing-button"><a href="'. $button_url .'" target="_'. $button_target .'" rel="'. $button_rel .'" '. $border_radius_style .' class="theme-button">'. $button_text .'</a></div>';
			}
		$pricing_content .= '</div>';
		return $pricing_content;
	}
}
add_shortcode( 'vcex_pricing', 'vcex_pricing_shortcode' );


/**
	Add to visual composer
**/
add_action( 'init', 'vcex_pricing_shortcode_vc_map' );
if ( ! function_exists( 'vcex_pricing_shortcode_vc_map' ) ) {
	function vcex_pricing_shortcode_vc_map() {
		vc_map( array(
			"name"					=> __( "Pricing Table", 'wpex' ),
			"description"			=> __( "Insert a pricing column", 'wpex' ),
			"base"					=> "vcex_pricing",
			'category'				=> WPEX_THEME_BRANDING,
			"icon"					=> "icon-wpb-vcex-pricing",
			"params"				=> array(
				array(
					"type"			=> "textarea_html",
					"heading"		=> __( "Features", 'wpex' ),
					"param_name"	=> "content",
					"value"			=> "<ul>
											<li>30GB Storage</li>
											<li>512MB Ram</li>
											<li>10 databases</li>
											<li>1,000 Emails</li>
											<li>25GB Bandwidth</li>
										</ul>",
					"description"	=> __('Enter your pricing content. You can use a UL list as shown by default but anything would really work!','wpex'),
					'group'			=> __( 'Features', 'wpex' ),
				),
				array(
					"type"			=> "dropdown",
					"class"			=> "",
					"heading"		=> __( "Featured", 'wpex' ),
					"param_name"	=> "featured",
					"value"			=> array(
						__( "No", "wpex" )	=> "no",
						__( "Yes", "wpex")	=> "yes",
					),
					"description"	=> __('Is this a featured pricing entry?','wpex'),
					'group'			=> __( 'General', 'wpex' ),
				),
				array(
					"type"			=> "textfield",
					"class"			=> "",
					"heading"		=> __( "Plan", 'wpex' ),
					"admin_label"	=> true,
					"param_name"	=> "plan",
					"value"			=> "Basic",
					"description"	=> __('Main pricing heading.','wpex'),
					'group'			=> __( 'General', 'wpex' ),
				),
				array(
					"type"			=> "textfield",
					"class"			=> "",
					"heading"		=> __( "Cost", 'wpex' ),
					"param_name"	=> "cost",
					"value"			=> "$20",
					"description"	=> __('Enter a cost for this plan.','wpex'),
					'group'			=> __( 'General', 'wpex' ),
				),
				array(
					"type"			=> "textfield",
					"class"			=> "",
					"heading"		=> __( "Per (optional)", 'wpex' ),
					"param_name"	=> "per",
					"value"			=> "/ month",
					"description"	=> __('Use this field to add a small text next to the pricing cost. Ideal for things like /month.','wpex'),
					'group'			=> __( 'General', 'wpex' ),
				),
				array(
					"type"			=> "textfield",
					"class"			=> "",
					"heading"		=> __( "Button: Text", 'wpex' ),
					"param_name"	=> "button_text",
					"value"			=> "Button Text",
					"description"	=> __( "Enter the text for your pricing button.", 'wpex' ),
					'group'			=> __( 'Button', 'wpex' ),
				),
				array(
					"type"			=> "textfield",
					"class"			=> "",
					"heading"		=> __( "Button: URL", 'wpex' ),
					"param_name"	=> "button_url",
					"value"			=> "http://www.google.com/",
					"description"	=> __( "Enter a URL for your pricing button.", 'wpex' ),
					'group'			=> __( 'Button', 'wpex' ),
				),
				array(
					"type"			=> "dropdown",
					"class"			=> "",
					"heading"		=> __( "Button: Link Target", 'wpex' ),
					"param_name"	=> "button_target",
					"value"			=> array(
						__( "Self", "wpex")		=> "self",
						__( "Blank", "wpex" )	=> "blank",
					),
					"description"	=> __( 'Your link target. Choose self to open the link in the same browser tab and blank to open in a new tab.', 'wpex' ),
					'group'			=> __( 'Button', 'wpex' ),
				),
				array(
					"type"			=> "dropdown",
					"class"			=> "",
					"heading"		=> __( "Button: Rel", 'wpex' ),
					"param_name"	=> "button_rel",
					"value"			=> array(
						__( "None", "wpex")		=> "none",
						__( "Nofollow", "wpex" )	=> "nofollow",
					),
					"description"	=> __( 'Select a rel attribute for your link.', 'wpex' ),
					'group'			=> __( 'Button', 'wpex' ),
				),
			)
		) );
	}
}