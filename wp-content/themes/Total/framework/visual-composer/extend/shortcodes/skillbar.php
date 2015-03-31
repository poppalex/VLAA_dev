<?php
/**
	Skillbars
**/
if( !function_exists('vcex_skillbar_shortcode') ) {
	function vcex_skillbar_shortcode( $atts  ) {
		extract( shortcode_atts( array(
			'title'				=> '',
			'percentage'		=> '100',
			'color'				=> '#6adcfa',
			'class'				=> '',
			'show_percent'		=> 'true',
			'css_animation'		=> '',
		), $atts ) );

		// Enable output buffer
		ob_start();
		
			// Animation classes
			$css_animation_classes = '';
			if ( $css_animation !== '' ) {
				$css_animation_classes = 'wpb_animate_when_almost_visible wpb_'. $css_animation .'';
			}
			
			// Percentage
			$percentage = $percentage ? preg_replace("/[^0-9]/","", $percentage) : '';

			// Front End composer js
			if ( wpex_is_front_end_composer() ) { ?>
				<script type="text/javascript">
					jQuery(function($){
						$('.vcex-skillbar').each(function(){
							$(this).find('.vcex-skillbar-bar').animate({ width: $(this).attr('data-percent') }, 800 );
						});
					});
				</script>
			<?php } ?>

			<div class="vcex-skillbar vcex-clearfix <?php echo $class; ?> <?php echo $css_animation_classes; ?>" data-percent="<?php echo $percentage; ?>%">
				<div class="vcex-skillbar-title" style="background: <?php echo $color; ?>;"><span><?php echo $title; ?></span></div>
				<div class="vcex-skillbar-bar" style="background:<?php echo $color; ?>;">
					<?php if ( $show_percent == 'true' ) { ?>
						<div class="vcex-skill-bar-percent"><?php echo $percentage; ?>%</div>
					<?php } ?>
				</div>
			</div>

		<?php
		// Return content
		return ob_get_clean();
	}
}
add_shortcode( 'vcex_skillbar', 'vcex_skillbar_shortcode' );


/**
	Add to visual composer
**/
add_action( 'init', 'vcex_skillbar_shortcode_vc_map' );
if ( ! function_exists( 'vcex_skillbar_shortcode_vc_map' ) ) {
	function vcex_skillbar_shortcode_vc_map() {
		vc_map( array(
			"name"					=> __( "Skill Bar", 'wpex' ),
			"description"			=> __( "Animated skill bar", 'wpex' ),
			"base"					=> "vcex_skillbar",
			'category'				=> WPEX_THEME_BRANDING,
			"icon"					=> "icon-wpb-vcex-skillbar",
			"params"				=> array(
				array(
					"type"			=> "textfield",
					"class"			=> "",
					"heading"		=> __( "Title", 'wpex' ),
					"param_name"	=> "title",
					"admin_label"	=> true,
					"value"			=> "Web Design",
					"description"	=> __( "Add your skillbar title.", 'wpex' )
				),
				array(
					"type"			=> "dropdown",
					"heading"		=> __("CSS Animation", "wpex"),
					"param_name"	=> "css_animation",
					"value"			=> array(
						__("No", "wpex")					=> '',
						__("Top to bottom", "wpex")			=> "top-to-bottom",
						__("Bottom to top", "wpex")			=> "bottom-to-top",
						__("Left to right", "wpex")			=> "left-to-right",
						__("Right to left", "wpex")			=> "right-to-left",
						__("Appear from center", "wpex")	=> "appear"),
					"description"							=> __("Select animation type if you want this element to be animated when it enters into the browsers viewport. Note: Works only in modern browsers.", "wpex")
				),
				array(
					"type"			=> "textfield",
					"class"			=> "",
					"heading"		=> __( "Percentage", 'wpex' ),
					"param_name"	=> "percentage",
					"value"			=> "70",
					"description"	=> __( "Add a percentage value.", 'wpex' )
				),
				array(
					"type"			=> "colorpicker",
					"class"			=> "",
					"heading"		=> __( "Background", 'wpex' ),
					"param_name"	=> "color",
					"value"			=> "#65C25C",
					"description"	=> __( "Choose your custom background color (Hex value).", 'wpex' ),
				),
				array(
					"type"			=> "dropdown",
					"class"			=> "",
					"heading"		=> __( "Display % Number", 'wpex' ),
					"param_name"	=> "show_percent",
					"value"			=> array(
						__( "True", "wpex" )	=> "true",
						__( "False", "wpex" )	=> "false",
					),
					"description"	=> __( "Display the percentage on the front-end?", 'wpex' )
				),
			)
		) );
	}
}